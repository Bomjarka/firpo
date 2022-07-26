<?php

require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';
require_once 'models/Model.php';
require_once 'generators/BaseGenerator.php';
require_once 'services/Service.php';
require_once 'interfaces/DatabaseInterface.php';
require_once 'helpers/InputHelper.php';
require_once 'models/User.php';
require_once 'services/AuthorizationService.php';
require_once 'services/PasswordService.php';
require_once 'services/RegistrationService.php';
require_once 'services/UserService.php';
require_once 'components/MYSQLDatabase.php';
require_once 'helpers/DateTimeHelper.php';
require_once 'services/SQLTestQueryService.php';
require_once 'generators/TestDataGenerator.php';
require_once 'helpers/Functions.php';
require_once 'components/PostgresqlDatabase.php';
require_once 'services/DatabaseService.php';
require_once 'services/DotEnv.php';
require_once 'services/XMLService.php';
require_once 'services/PetService.php';
require_once 'models/Pet.php';
require_once 'services/PetOwnerService.php';
require_once 'models/PetOwner.php';



Route::start();
