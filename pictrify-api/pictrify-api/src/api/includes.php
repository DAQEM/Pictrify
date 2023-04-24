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
require_once './controllers/SectionController.php';
require_once './controllers/SectionItemController.php';

require_once './utils/Guid.php';
require_once './utils/UTCDate.php';

require_once './exceptions/HttpException.php';
require_once './exceptions/NotFoundException.php';
require_once './exceptions/MethodNotAllowedException.php';
require_once './exceptions/ForbiddenException.php';
require_once './exceptions/BadRequestException.php';
require_once './exceptions/InvalidUrlException.php';

require_once './gateway/GatewayInjection.php';
require_once './gateway/interfaces/ICreatorGateway.php';
require_once './gateway/interfaces/IPhotoAlbumGateway.php';
require_once './gateway/interfaces/ISectionGateway.php';
require_once './gateway/interfaces/ISectionItemGateway.php';

require_once './services/BaseService.php';
require_once './services/CreatorService.php';
require_once './services/PhotoAlbumService.php';
require_once './services/SectionService.php';
require_once './services/SectionItemService.php';


// Gateway

require_once '../gateway/database/DatabaseHelper.php';
require_once '../gateway/database/DatabaseConnection.php';

require_once '../gateway/implementation/CreatorGateway.php';
require_once '../gateway/implementation/PhotoAlbumGateway.php';
require_once '../gateway/implementation/SectionGateway.php';
require_once '../gateway/implementation/SectionItemGateway.php';