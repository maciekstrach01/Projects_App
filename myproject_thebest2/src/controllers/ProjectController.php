<?php
//
//require_once 'AppController.php';
//require_once __DIR__ .'/../models/Project.php';
//require_once __DIR__.'/../repository/ProjectRepository.php';
//
//class ProjectController extends AppController {
//
//    const MAX_FILE_SIZE = 1024*1024;
//    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
//    const UPLOAD_DIRECTORY = '/../public/uploads/';
//
//    private $message = [];
//    private $projectRepository;
//
//    public function __construct()
//    {
//        parent::__construct();
//        $this->projectRepository = new ProjectRepository();
//    }
//
//    public function projects()
//    {
//        $projects = $this->projectRepository->getProjects();
//        $this->render('projects', ['projects' => $projects]);
//    }
//
//    public function addProject()
//    {
//        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
//            move_uploaded_file(
//                $_FILES['file']['tmp_name'],
//                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
//            );
//
//            // TODO create new project object and save it in database
//            $project = new Project($_POST['title'], $_POST['description'], $_FILES['file']['name']);
//            $this->projectRepository->addProject($project);
//
//            return $this->render('projects', [
//                'messages' => $this->message,
//                'projects' => $this->projectRepository->getProjects()
//            ]);
//        }
//
//        return $this->render('add-project', ['messages' => $this->message]);
//    }
//
//    private function validate(array $file): bool
//    {
//        if ($file['size'] > self::MAX_FILE_SIZE) {
//            $this->message[] = 'File is too large for destination file system.';
//            return false;
//        }
//
//        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
//            $this->message[] = 'File type is not supported.';
//            return false;
//        }
//        return true;
//    }
//}


require_once 'AppController.php';
require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../repository/ProjectRepository.php';

class ProjectController extends AppController
{

    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $projectRepository;

    public function __construct()
    {
        parent::__construct();
        $this->projectRepository = new ProjectRepository();
    }

    public function projectDetails()
    {
        if (!isset($_GET['id'])) {
            // handle the error, e.g., redirect to the projects page or show a 404 page
            return $this->render('projects', ['projects' => $this->projectRepository->getProjects()]);
        }

        $project = $this->projectRepository->getProject($_GET['id']);
        if (!$project) {
            // handle the error, e.g., show a 404 page
            return $this->render('projects', ['projects' => $this->projectRepository->getProjects()]);
        }

        $this->render('project-details', ['project' => $project]);
    }

    public function projects()
    {
        $projects = $this->projectRepository->getProjects();
        $this->render('projects', ['projects' => $projects]);
    }

    public function addProject()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            // TODO create new project object and save it in database
            $project = new Project(null,$_POST['title'], $_POST['description'], $_FILES['file']['name']);
            $this->projectRepository->addProject($project);

            return $this->render('projects', [
                'messages' => $this->message,
                'projects' => $this->projectRepository->getProjects()
            ]);
        }

        return $this->render('add-project', ['messages' => $this->message]);
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->projectRepository->getProjectByTitle($decoded['search']));
        }
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }
}
