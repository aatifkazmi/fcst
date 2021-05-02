<?php

namespace User\Controller;



use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\ViewModel;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;

use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

use Zend\Paginator\Paginator;

use Application\Entity\Post;

use User\Entity\Users;

use User\Entity\Modules;

use User\Entity\Courses;

use User\Entity\Progress;

use User\Entity\Questions;

use User\Entity\Quizzes;

use User\Entity\UsersHasCourses;

use User\Entity\Videos;

use User\Form\UserForm;

use User\Form\PasswordChangeForm;

use User\Form\PasswordResetForm;



/**

 * This controller is responsible for user management (adding, editing, 

 * viewing users and changing user's password).

 */

class CoursesController extends AbstractActionController 

{

    /**

     * Entity manager.

     * @var Doctrine\ORM\EntityManager

     */

    private $entityManager;

    private $tcpdf;



    /**

     * Constructor. 

     */

    public function __construct($entityManager,$authService, $tcpdf, $renderer)

    {

        $this->entityManager = $entityManager;

        $this->authService = $authService;

        $this->tcpdf = $tcpdf;

        $this->renderer = $renderer;

    }

    

    /**

     * This is the default "index" action of the controller. It displays the 

     * list of courses.

     */

    public function indexAction() 

    {

    

        $user = $this->entityManager->getRepository(Users::class)

                ->findOneByEmail($this->authService->getIdentity());

                

        $courses = $user->getCourses();



        return new ViewModel([

            'courses' => $courses

        ]);

    } 



    public function viewAction() {



        $id = $this->params()->fromRoute('id', 0);

        // Validate input parameter

        if ($id == 0) {

            $this->getResponse()->setStatusCode(404);

            return;

        }

        

        // Find the course by ID

        $course = $this->entityManager->getRepository(Courses::class)

                ->findOneById($id);



        

        if ($course == null) {

            $this->getResponse()->setStatusCode(404);

             throw new \Exception("Invalid courseId");

            return;                        

        }  



        $email = $this->authService->getIdentity();   

        

        $user = $this->entityManager->getRepository(Users::class)

                ->findOneBy(['email' => $email]);



        $videos = $this->entityManager->getRepository(Courses::class)

            ->fetchModulesAndVideos($id, $user->getId())->getResult();

             

        $keyedCourses = array();

        foreach($videos as $video) {

            $keyedCourses['course'] = $video->getModules()->getCourses();

            $keyedCourses[$video->getModules()->getId()]['name'] = $video->getModules()->getName();

            $keyedCourses[$video->getModules()->getId()]['videos'][$video->getId()] = $video;

        }



        return new ViewModel([

            'courses' => $keyedCourses

        ]); 

    

    }



    public function courseAction()

    { 

        $id = $this->params()->fromRoute('id', 0);

        $videoId = $this->params()->fromRoute('video', 0);

        $moduleId = $this->params()->fromRoute('module', 0);



        // Validate input parameter

        if ($id == 0) {

            $this->getResponse()->setStatusCode(404);

            return;

        }

        $email = $this->authService->getIdentity();   

        

        $user = $this->entityManager->getRepository(Users::class)

                ->findOneBy(['email' => $email]);



        $videos = $this->entityManager->getRepository(Courses::class)

            ->fetchModulesAndVideos($id, $user->getId())->getResult();

             

        $keyedCourses = array();

        $activeVideo = null;

        $activeModule = null;

        $pageTrack = array();

        foreach($videos as $video) {

            $keyedCourses['course'] = $video->getModules()->getCourses();

            $keyedCourses[$video->getModules()->getId()]['name'] = $video->getModules()->getName();

            $keyedCourses[$video->getModules()->getId()]['videos'][$video->getId()] = $video;

            

            if(!$moduleId && !$activeModule) {

                $activeModule =  $video->getModules();

            }

            if(!$videoId && !$activeVideo) {

                $activeVideo =  $video;

            }

            if($videoId == $video->getId()) {

                $activeVideo = $video;

            }

            if($moduleId == $video->getModules()->getId()) {

                $activeModule = $video->getModules();

            }

            $pageTrack['video-' . $video->getId() . '-module-' . $video->getModules()->getId()] = [

                'video' => $video->getId(),

                'module' => $video->getModules()->getId()

            ];

        }



        $progress = $this->entityManager->getRepository(Progress::class)

                ->findOneBy(['user' => $user->getId(), 'status' => 'watching']);



        if(!$videoId && $progress) {

            $activeVideo = $progress->getVideos();

            $activeModule = $activeVideo->getModules();

        }



        return new ViewModel([

            'courses' => $keyedCourses,

            'active_video' => $activeVideo,

            'active_module' => $activeModule,

            'page_track' => $pageTrack,

            'course_id' => $id

        ]);

    }



    public function playVideoAction() {



        $id = $this->params()->fromRoute('id', 0);

        $video = $this->entityManager->getRepository(Videos::class)

            ->find($id);



        $email = $this->authService->getIdentity();   

    

        $user = $this->entityManager->getRepository(Users::class)

                ->findOneBy(['email' => $email]);



        $wachingVideo = $this->entityManager->getRepository(Progress::class)

                ->findOneBy(['user' => $user->getId(), 'status' => 'watching']);

         

        if($wachingVideo) {



            $wachingVideo->setStatus('watched');

        }



        $progress = new Progress();



        $progress->setVideos($video);

        $progress->setUser($user);

        $progress->setStatus('watching');



        try{

            $this->entityManager->persist($progress);

            $this->entityManager->flush();

        } catch(\Exception $e) {



        }



        $file='data/course-videos/' . $video->getFile();



        header('Content-Type: video/mp4'); #Optional if you'll only load it from other pages

        header('Accept-Ranges: bytes');

        $this->readfile_chunked($file);

        exit;

    }



    public function certificateAction() {



        $id = $this->params()->fromRoute('id', 0);



        $course = $this->entityManager->getRepository(Courses::class)

            ->findOneBy(['id' => $id]);



        $email = $this->authService->getIdentity();   

    

        $user = $this->entityManager->getRepository(Users::class)

                ->findOneBy(['email' => $email]);



        $userAnswers = $this->entityManager->getRepository(Quizzes::class)

                ->fetchUserAnswers($id, $user->getId())->getResult();



        $quizQuestions = $this->entityManager->getRepository(Quizzes::class)

                ->fetchQuestions($id)->getResult();

        

        $totalQuestions = sizeof($quizQuestions);



        $correctAnswerCount = 0;

       

        if($userAnswers) {

            

            foreach($userAnswers as $answer) {

               

                $question = $this->entityManager->getRepository(Questions::class)

                    ->find($answer->getQuestions());

                

                if($question->getCorrectAnswerKey() == $answer->getUserAnswerKey()){

                    $correctAnswerCount++;

                }

            }

        }



        $percentage = $correctAnswerCount/$totalQuestions*100;



        $userHasCourse = $this->entityManager->getRepository(UsersHasCourses::class)

                ->findOneBy(['courses' => $course->getId(), 'users' => $user->getId()]);




        $view = new ViewModel([

            'course_title' => $course->getTitle(),

            'name' => $user->getName(),

            'percentage' => $percentage,

            'date' => $userHasCourse->getQualifiedDate(),

        ]);



        $renderer = $this->renderer;

        $view->setTemplate('layout/pdf');

        $html = $renderer->render($view);



        $pdf = $this->tcpdf;



        $pdf->SetFont('arialnarrow', '', 12, '', false);

        $pdf->AddPage();

        $pdf->writeHTML($html, true, false, true, false, '');



        $pdf->Output();

    }



    // Read a file and display its content chunk by chunk

    function readfile_chunked($filename, $retbytes = TRUE) {

        $buffer = '';

        $cnt    = 0;

        $handle = fopen($filename, 'rb');



        if ($handle === false) {

            return false;

        }



        while (!feof($handle)) {

            $buffer = fread($handle, 1024*1024);

            echo $buffer;

            ob_flush();

            flush();



            if ($retbytes) {

                $cnt += strlen($buffer);

            }

        }



        $status = fclose($handle);



        if ($retbytes && $status) {

            return $cnt; // return num. bytes delivered like readfile() does.

        }



        return $status;

    }

}





