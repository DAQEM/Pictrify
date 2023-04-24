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
require_once './controllers/ImageController.php';
require_once './controllers/PhotoAlbumCommentController.php';

require_once './utils/Guid.php';
require_once './utils/UTCDate.php';

require_once './exceptions/HttpException.php';
require_once './exceptions/NotFoundException.php';
require_once './exceptions/MethodNotAllowedException.php';
require_once './exceptions/ForbiddenException.php';
require_once './exceptions/BadRequestException.php';
require_once './exceptions/InvalidUrlException.php';

require_once './repository/RepositoryInjection.php';
require_once './repository/interfaces/ICreatorRepository.php';
require_once './repository/interfaces/IPhotoAlbumRepository.php';
require_once './repository/interfaces/ISectionRepository.php';
require_once './repository/interfaces/ISectionItemRepository.php';
require_once './repository/interfaces/IImageRepository.php';
require_once './repository/interfaces/IPhotoAlbumCommentRepository.php';

require_once './services/BaseService.php';
require_once './services/CreatorService.php';
require_once './services/PhotoAlbumService.php';
require_once './services/SectionService.php';
require_once './services/SectionItemService.php';
require_once './services/ImageService.php';
require_once './services/PhotoAlbumCommentService.php';


// Repository

require_once '../repository/database/DatabaseHelper.php';
require_once '../repository/database/DatabaseConnection.php';

require_once '../repository/implementation/CreatorRepository.php';
require_once '../repository/implementation/PhotoAlbumRepository.php';
require_once '../repository/implementation/SectionRepository.php';
require_once '../repository/implementation/SectionItemRepository.php';
require_once '../repository/implementation/ImageRepository.php';
require_once '../repository/implementation/PhotoAlbumCommentRepository.php';