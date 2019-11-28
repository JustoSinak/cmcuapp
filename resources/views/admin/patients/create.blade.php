@extends('layouts.admin')

@section('title', 'CMCU | Ajouter un dossier patient')

@section('content')

    <body>
    <div class="se-pr-con"></div>
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->

        <div class="container">
            <h1 class="text-center">AJOUTER UN DOSSIER PATIENT</h1>
            <hr>
            @include('partials.flash_form')

            <div class="card" style="width: 40rem;">
                <div class="card-body">
                    <h5 class="card-title">Ajouter un patient</h5>
                    <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i class="fas fa-info-circle"></i></small>
                    <hr>
                    <form class="form-group col-md-10" action="{{ route('patients.store') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                        <div class="form-group">
                        <b>Médecin  :</b> <span class="text-danger">*</span>
                            
                                <select class="form-control" name="medecin_r" id="medecin_r" required>
                                    <option value="medecin_r"> Nom du médecin</option>
                                    @foreach ($users as $user)
                                        <option
                                            value="{{ $user->name }} {{ $user->prenom }}" {{old("medecin_r") ?: '' ? "selected": ""}}>{{ $user->name }} {{ $user->prenom }}
                                        </option>
                                    @endforeach
                                </select>
                           </div>
                        
                            <div class="form-group">
                                <label for="name" class="col-form-label text-md-right">Nom <span class="text-danger">*</span></label>
                                <input name="name" class="form-control" value="{{ old('name') }}" type="text" placeholder="Nom" required>
                            </div>
                            <div class="form-group">
                                <label for="prenom" class="col-form-label text-md-right">Prenom <span class="text-danger">*</span></label>
                                <input name="prenom" class="form-control" value="{{ old('prenom') }}" type="text" placeholder="prenom" >
                            </div>
                            <div class="form-group">
                                <label for="montant" class="col-form-label text-md-right">Montant <span class="text-danger">*</span></label>
                                <input name="montant" class="form-control" value="{{ old('montant') }}" type="number" placeholder="montant" >
                            </div>
                            <div class="form-group">
                                <label for="avance" class="col-form-label text-md-right">avance</label>
                                <input name="avance" class="form-control" value="{{ old('avance') }}" type="text" placeholder="avance" >
                            </div>
                            <div class="form-group">
                            <label for="demarcheur"> Démarcheur : <span class="text-danger"></span></label>
                            <select class="form-control" name="demarcheur" id="demarcheur" >
                                <option></option>
                                <option>DMH</option>
                            </select>
                        </div>
                            <div class="form-group">
                            
                            <div class="form-group">
                                <label for="assurance" class="col-form-label text-md-right">Assurance</label>
                                <input name="assurance" class="form-control" value="{{ old('assurance') }}" type="text" placeholder=" nom de l'assurance si le patient est assuré" >
                            </div>

                            <div class="form-group">
                                <label for="numero_assurance" class="col-form-label text-md-right">Numéro d'assurance</label>
                                <input name="numero_assurance" class="form-control" value="{{ old('numero_assurance') }}" type="text" placeholder="Numéro d'assurance si le patient est assuré" >
                            </div>
                            <div class="form-group">
                            <label for="prise_en_charge"> Taux de Prise en Charge : <span class="text-danger"></span></label>
                            <select class="form-control" name="prise_en_charge" id="prise_en_charge" required>
                            <option>aucune</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                 <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                 <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                 <option>16</option>
                                <option>17</option>
                                <option>18</option>
                                <option>19</option>
                                <option>20</option>
                                <option>21</option>
                                 <option>22</option>
                                <option>23</option>
                                <option>24</option>
                                <option>25</option>
                                <option>26</option>
                                <option>27</option>
                                 <option>28</option>
                                <option>29</option>
                                <option>30</option>
                                <option>31</option>
                                <option>32</option>
                                <option>33</option>
                                 <option>34</option>
                                <option>35</option>
                                <option>36</option>
                                <option>37</option>
                                <option>38</option>
                                <option>39</option>
                                 <option>40</option>
                                <option>41</option>
                                <option>42</option>
                                <option>43</option>
                                <option>44</option>
                                <option>45</option>
                                 <option>46</option>
                                <option>47</option>
                                <option>48</option>
                                <option>49</option>
                                <option>50</option>
                                <option>51</option>
                                 <option>52</option>
                                <option>53</option>
                                <option>54</option>
                                <option>55</option>
                                <option>56</option>
                                <option>57</option>
                                 <option>58</option>
                                <option>59</option>
                                <option>60</option>
                                <option>61</option>
                                <option>62</option>
                                <option>63</option>
                                 <option>64</option>
                                <option>65</option>
                                <option>66</option>
                                <option>67</option>
                                <option>68</option>
                                <option>69</option>
                                 <option>70</option>
                                <option>71</option>
                                <option>72</option>
                                <option>73</option>
                                <option>74</option>
                                <option>75</option>
                                 <option>76</option>
                                <option>77</option>
                                <option>78</option>
                                <option>79</option>
                                <option>80</option>
                                <option>81</option>
                                 <option>82</option>
                                <option>83</option>
                                <option>84</option>
                                <option>85</option>
                                <option>86</option>
                                <option>87</option>
                                 <option>88</option>
                                <option>89</option>
                                <option>90</option>
                                <option>91</option>
                                <option>92</option>
                                <option>93</option>
                                 <option>94</option>
                                <option>95</option>
                                <option>96</option>
                                <option>97</option>
                                <option>98</option>
                                <option>99</option>
                                 <option>100</option>
                                
                            </select>
                        </div>
                        <div class="form-group">
                                <label for="assurance" class="col-form-label text-md-right">Date Création</label>
                                <input type="date" name="date_insertion" class="form-control" value="{{ old('date_insertion') }}"  placeholder=" date de création du dossier au cmcu" required>
                            </div>
                       
                        </div>

                            </br>

                            <button type="submit" class="btn btn-primary btn-lg col-md-5" title="En cliquant sur ce bouton vous enregistrer un nouveau patient">Ajouter</button>
                            <a href="{{ route('patients.index') }}" class="btn btn-warning btn-lg col-md-5 offset-md-1" title="Retour à la liste des patients">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </body>

@stop
