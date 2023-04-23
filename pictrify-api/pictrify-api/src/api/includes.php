<?php

require '/var/www/vendor/autoload.php';

// API

require_once './Request.php';

require_once './controllers/interfaces/IController.php';
require_once './controllers/interfaces/IHttpGet.php';
require_once './controllers/interfaces/IHttpPost.php';
require_once './controllers/interfaces/IHttpPut.php';
require_once './controllers/interfaces/IHttpDelete.php';

require_once './controllers/BaseController.php';
require_once './controllers/EntryController.php';
require_once './controllers/CreatorController.php';
require_once './controllers/PhotoAlbumController.php';

require_once './utils/Guid.php';
require_once './utils/UTCDate.php';

require_once './exceptions/HttpException.php';
require_once './exceptions/NotFoundException.php';
require_once './exceptions/MethodNotAllowedException.php';
require_once './exceptions/ForbiddenException.php';
require_once './exceptions/BadRequestException.php';
require_once './exceptions/InvalidUrlException.php';

require_once './gateway/GatewayInjection.php';
require_once './gateway/ICreatorGateway.php';
require_once './gateway/IPhotoAlbumGateway.php';


// Gateway

require_once '../gateway/database/DatabaseHelper.php';
require_once '../gateway/database/DatabaseConnection.php';

require_once '../gateway/implementation/CreatorGateway.php';
require_once '../gateway/implementation/PhotoAlbumGateway.php';