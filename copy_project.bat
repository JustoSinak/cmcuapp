@echo off
echo Copying project from UNC path to local drive...

:: Créer le dossier destination s'il n'existe pas
if not exist "C:\cmcuapp" mkdir "C:\cmcuapp"

:: Utiliser robocopy pour une copie plus fiable
robocopy "\\serveur\INFORMATICIEN 2N\JUSTO TCHEUMANI\cmcu\cmcuapp" "C:\cmcuapp" /E /Z /R:3 /W:5

if %errorlevel% leq 7 (
    echo Copy completed successfully.
) else (
    echo Copy failed with error code: %errorlevel%
)

pause