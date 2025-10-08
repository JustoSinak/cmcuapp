<?php

namespace App\Services;

use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ElasticsearchService
{
    protected $client;
    protected $indexPrefix;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([config('services.elasticsearch.host', 'localhost:9200')])
            ->build();
            
        $this->indexPrefix = config('app.name', 'cmcu') . '_';
    }

    /**
     * Index a patient document
     */
    public function indexPatient($patient): bool
    {
        try {
            $params = [
                'index' => $this->indexPrefix . 'patients',
                'id' => $patient->id,
                'body' => [
                    'id' => $patient->id,
                    'nom' => $patient->nom,
                    'prenom' => $patient->prenom,
                    'telephone' => $patient->telephone,
                    'adresse' => $patient->adresse,
                    'date_naissance' => $patient->date_naissance,
                    'created_at' => $patient->created_at->toISOString(),
                    'updated_at' => $patient->updated_at->toISOString(),
                    'full_name' => $patient->nom . ' ' . $patient->prenom,
                    'search_text' => $this->buildSearchText($patient),
                ]
            ];

            $response = $this->client->index($params);
            
            Log::info('Patient indexed in Elasticsearch', [
                'patient_id' => $patient->id,
                'elasticsearch_id' => $response['_id']
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to index patient in Elasticsearch', [
                'patient_id' => $patient->id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Advanced patient search with fuzzy matching and filters
     */
    public function searchPatients(string $query, array $filters = [], int $size = 20): array
    {
        try {
            $cacheKey = 'elasticsearch_patients_' . md5($query . serialize($filters) . $size);
            
            return Cache::remember($cacheKey, 300, function () use ($query, $filters, $size) {
                $searchBody = $this->buildPatientSearchQuery($query, $filters);
                
                $params = [
                    'index' => $this->indexPrefix . 'patients',
                    'body' => $searchBody,
                    'size' => $size,
                ];

                $response = $this->client->search($params);
                
                return $this->formatSearchResults($response);
            });

        } catch (\Exception $e) {
            Log::error('Elasticsearch patient search failed', [
                'query' => $query,
                'error' => $e->getMessage()
            ]);

            // Fallback to database search
            return $this->fallbackPatientSearch($query, $filters, $size);
        }
    }

    /**
     * Index a consultation document
     */
    public function indexConsultation($consultation): bool
    {
        try {
            $params = [
                'index' => $this->indexPrefix . 'consultations',
                'id' => $consultation->id,
                'body' => [
                    'id' => $consultation->id,
                    'patient_id' => $consultation->patient_id,
                    'user_id' => $consultation->user_id,
                    'description' => $consultation->description,
                    'diagnostic' => $consultation->diagnostic ?? '',
                    'traitement' => $consultation->traitement ?? '',
                    'created_at' => $consultation->created_at->toISOString(),
                    'patient_name' => $consultation->patient ? 
                        $consultation->patient->nom . ' ' . $consultation->patient->prenom : '',
                    'doctor_name' => $consultation->user ? $consultation->user->name : '',
                    'search_text' => $this->buildConsultationSearchText($consultation),
                ]
            ];

            $response = $this->client->index($params);
            
            Log::info('Consultation indexed in Elasticsearch', [
                'consultation_id' => $consultation->id,
                'elasticsearch_id' => $response['_id']
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to index consultation in Elasticsearch', [
                'consultation_id' => $consultation->id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Advanced consultation search
     */
    public function searchConsultations(string $query, array $filters = [], int $size = 20): array
    {
        try {
            $cacheKey = 'elasticsearch_consultations_' . md5($query . serialize($filters) . $size);
            
            return Cache::remember($cacheKey, 300, function () use ($query, $filters, $size) {
                $searchBody = $this->buildConsultationSearchQuery($query, $filters);
                
                $params = [
                    'index' => $this->indexPrefix . 'consultations',
                    'body' => $searchBody,
                    'size' => $size,
                ];

                $response = $this->client->search($params);
                
                return $this->formatSearchResults($response);
            });

        } catch (\Exception $e) {
            Log::error('Elasticsearch consultation search failed', [
                'query' => $query,
                'error' => $e->getMessage()
            ]);

            return $this->fallbackConsultationSearch($query, $filters, $size);
        }
    }

    /**
     * Global search across all indexed documents
     */
    public function globalSearch(string $query, int $size = 50): array
    {
        try {
            $cacheKey = 'elasticsearch_global_' . md5($query . $size);
            
            return Cache::remember($cacheKey, 300, function () use ($query, $size) {
                $params = [
                    'index' => $this->indexPrefix . '*',
                    'body' => [
                        'query' => [
                            'multi_match' => [
                                'query' => $query,
                                'fields' => ['search_text^2', 'full_name^3', 'nom^2', 'prenom^2', 'description'],
                                'fuzziness' => 'AUTO',
                                'operator' => 'or'
                            ]
                        ],
                        'highlight' => [
                            'fields' => [
                                'search_text' => new \stdClass(),
                                'full_name' => new \stdClass(),
                                'description' => new \stdClass()
                            ]
                        ],
                        'sort' => [
                            '_score' => ['order' => 'desc'],
                            'created_at' => ['order' => 'desc']
                        ]
                    ],
                    'size' => $size,
                ];

                $response = $this->client->search($params);
                
                return $this->formatGlobalSearchResults($response);
            });

        } catch (\Exception $e) {
            Log::error('Elasticsearch global search failed', [
                'query' => $query,
                'error' => $e->getMessage()
            ]);

            return ['patients' => [], 'consultations' => [], 'total' => 0];
        }
    }

    /**
     * Get search suggestions/autocomplete
     */
    public function getSuggestions(string $query, string $type = 'patients'): array
    {
        try {
            $params = [
                'index' => $this->indexPrefix . $type,
                'body' => [
                    'suggest' => [
                        'text' => $query,
                        'suggestions' => [
                            'term' => [
                                'field' => $type === 'patients' ? 'full_name' : 'description'
                            ]
                        ]
                    ]
                ]
            ];

            $response = $this->client->search($params);
            
            return $this->formatSuggestions($response);

        } catch (\Exception $e) {
            Log::error('Elasticsearch suggestions failed', [
                'query' => $query,
                'type' => $type,
                'error' => $e->getMessage()
            ]);

            return [];
        }
    }

    /**
     * Delete document from index
     */
    public function deleteDocument(string $index, int $id): bool
    {
        try {
            $params = [
                'index' => $this->indexPrefix . $index,
                'id' => $id
            ];

            $this->client->delete($params);
            
            Log::info('Document deleted from Elasticsearch', [
                'index' => $index,
                'id' => $id
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to delete document from Elasticsearch', [
                'index' => $index,
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Create index with proper mappings
     */
    public function createIndex(string $index): bool
    {
        try {
            $mappings = $this->getIndexMappings($index);
            
            $params = [
                'index' => $this->indexPrefix . $index,
                'body' => [
                    'mappings' => $mappings,
                    'settings' => [
                        'number_of_shards' => 1,
                        'number_of_replicas' => 0,
                        'analysis' => [
                            'analyzer' => [
                                'french_analyzer' => [
                                    'type' => 'custom',
                                    'tokenizer' => 'standard',
                                    'filter' => ['lowercase', 'french_stop', 'french_stemmer']
                                ]
                            ],
                            'filter' => [
                                'french_stop' => [
                                    'type' => 'stop',
                                    'stopwords' => '_french_'
                                ],
                                'french_stemmer' => [
                                    'type' => 'stemmer',
                                    'language' => 'french'
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $this->client->indices()->create($params);
            
            Log::info('Elasticsearch index created', ['index' => $index]);
            
            return true;

        } catch (\Exception $e) {
            Log::error('Failed to create Elasticsearch index', [
                'index' => $index,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Build patient search query
     */
    private function buildPatientSearchQuery(string $query, array $filters): array
    {
        $must = [];
        $filter = [];

        // Main search query
        if (!empty($query)) {
            $must[] = [
                'multi_match' => [
                    'query' => $query,
                    'fields' => ['full_name^3', 'nom^2', 'prenom^2', 'telephone^2', 'search_text'],
                    'fuzziness' => 'AUTO',
                    'operator' => 'or'
                ]
            ];
        }

        // Date range filter
        if (!empty($filters['date_from']) || !empty($filters['date_to'])) {
            $dateRange = [];
            if (!empty($filters['date_from'])) {
                $dateRange['gte'] = $filters['date_from'];
            }
            if (!empty($filters['date_to'])) {
                $dateRange['lte'] = $filters['date_to'];
            }
            
            $filter[] = [
                'range' => [
                    'created_at' => $dateRange
                ]
            ];
        }

        return [
            'query' => [
                'bool' => [
                    'must' => $must ?: [['match_all' => new \stdClass()]],
                    'filter' => $filter
                ]
            ],
            'sort' => [
                '_score' => ['order' => 'desc'],
                'created_at' => ['order' => 'desc']
            ],
            'highlight' => [
                'fields' => [
                    'full_name' => new \stdClass(),
                    'search_text' => new \stdClass()
                ]
            ]
        ];
    }

    /**
     * Build consultation search query
     */
    private function buildConsultationSearchQuery(string $query, array $filters): array
    {
        $must = [];
        $filter = [];

        if (!empty($query)) {
            $must[] = [
                'multi_match' => [
                    'query' => $query,
                    'fields' => ['description^3', 'diagnostic^2', 'traitement^2', 'patient_name^2', 'search_text'],
                    'fuzziness' => 'AUTO',
                    'operator' => 'or'
                ]
            ];
        }

        // Patient filter
        if (!empty($filters['patient_id'])) {
            $filter[] = [
                'term' => [
                    'patient_id' => $filters['patient_id']
                ]
            ];
        }

        // Doctor filter
        if (!empty($filters['user_id'])) {
            $filter[] = [
                'term' => [
                    'user_id' => $filters['user_id']
                ]
            ];
        }

        return [
            'query' => [
                'bool' => [
                    'must' => $must ?: [['match_all' => new \stdClass()]],
                    'filter' => $filter
                ]
            ],
            'sort' => [
                '_score' => ['order' => 'desc'],
                'created_at' => ['order' => 'desc']
            ],
            'highlight' => [
                'fields' => [
                    'description' => new \stdClass(),
                    'diagnostic' => new \stdClass(),
                    'patient_name' => new \stdClass()
                ]
            ]
        ];
    }

    /**
     * Format search results
     */
    private function formatSearchResults($response): array
    {
        $results = [];
        
        foreach ($response['hits']['hits'] as $hit) {
            $result = $hit['_source'];
            $result['_score'] = $hit['_score'];
            
            if (isset($hit['highlight'])) {
                $result['_highlights'] = $hit['highlight'];
            }
            
            $results[] = $result;
        }

        return [
            'results' => $results,
            'total' => $response['hits']['total']['value'] ?? 0,
            'max_score' => $response['hits']['max_score'] ?? 0
        ];
    }

    /**
     * Format global search results
     */
    private function formatGlobalSearchResults($response): array
    {
        $patients = [];
        $consultations = [];
        
        foreach ($response['hits']['hits'] as $hit) {
            $result = $hit['_source'];
            $result['_score'] = $hit['_score'];
            $result['_index'] = $hit['_index'];
            
            if (isset($hit['highlight'])) {
                $result['_highlights'] = $hit['highlight'];
            }
            
            if (str_contains($hit['_index'], 'patients')) {
                $patients[] = $result;
            } elseif (str_contains($hit['_index'], 'consultations')) {
                $consultations[] = $result;
            }
        }

        return [
            'patients' => $patients,
            'consultations' => $consultations,
            'total' => $response['hits']['total']['value'] ?? 0
        ];
    }

    /**
     * Format suggestions
     */
    private function formatSuggestions($response): array
    {
        $suggestions = [];
        
        if (isset($response['suggest']['suggestions'][0]['options'])) {
            foreach ($response['suggest']['suggestions'][0]['options'] as $option) {
                $suggestions[] = $option['text'];
            }
        }

        return array_unique($suggestions);
    }

    /**
     * Build search text for patient
     */
    private function buildSearchText($patient): string
    {
        return implode(' ', array_filter([
            $patient->nom,
            $patient->prenom,
            $patient->telephone,
            $patient->adresse,
        ]));
    }

    /**
     * Build search text for consultation
     */
    private function buildConsultationSearchText($consultation): string
    {
        return implode(' ', array_filter([
            $consultation->description,
            $consultation->diagnostic,
            $consultation->traitement,
            $consultation->patient ? $consultation->patient->nom . ' ' . $consultation->patient->prenom : '',
            $consultation->user ? $consultation->user->name : '',
        ]));
    }

    /**
     * Get index mappings
     */
    private function getIndexMappings(string $index): array
    {
        if ($index === 'patients') {
            return [
                'properties' => [
                    'id' => ['type' => 'integer'],
                    'nom' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'prenom' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'telephone' => ['type' => 'keyword'],
                    'adresse' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'full_name' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'search_text' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'created_at' => ['type' => 'date'],
                    'updated_at' => ['type' => 'date'],
                ]
            ];
        }

        if ($index === 'consultations') {
            return [
                'properties' => [
                    'id' => ['type' => 'integer'],
                    'patient_id' => ['type' => 'integer'],
                    'user_id' => ['type' => 'integer'],
                    'description' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'diagnostic' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'traitement' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'patient_name' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'doctor_name' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'search_text' => ['type' => 'text', 'analyzer' => 'french_analyzer'],
                    'created_at' => ['type' => 'date'],
                ]
            ];
        }

        return [];
    }

    /**
     * Fallback patient search using database
     */
    private function fallbackPatientSearch(string $query, array $filters, int $size): array
    {
        $patients = \App\Models\Patient::where(function ($q) use ($query) {
            $q->where('nom', 'LIKE', "%{$query}%")
              ->orWhere('prenom', 'LIKE', "%{$query}%")
              ->orWhere('telephone', 'LIKE', "%{$query}%");
        })
        ->limit($size)
        ->get()
        ->toArray();

        return [
            'results' => $patients,
            'total' => count($patients),
            'max_score' => 1.0
        ];
    }

    /**
     * Fallback consultation search using database
     */
    private function fallbackConsultationSearch(string $query, array $filters, int $size): array
    {
        $consultations = \App\Models\Consultation::where('description', 'LIKE', "%{$query}%")
            ->with(['patient:id,nom,prenom', 'user:id,name'])
            ->limit($size)
            ->get()
            ->toArray();

        return [
            'results' => $consultations,
            'total' => count($consultations),
            'max_score' => 1.0
        ];
    }
}
