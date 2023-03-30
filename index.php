<?php

    namespace App\Controller;

    use App\Services\DTV\YamlConfig\YamlReader;
    use App\Services\Platform\BackOffice\Statistics\Export\Base\StatisticsBase;
    use App\Services\Platform\BackOffice\Statistics\Export\StatisticsBridge;
    use DateTime;
    use Doctrine\ORM\EntityManagerInterface;
    use Exception;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use Psr\Log\LoggerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpKernel\KernelInterface;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Contracts\Translation\TranslatorInterface;

    class BackTestStatController extends AbstractController
    {

        private TranslatorInterface    $translator;
        private LoggerInterface        $logger;
        private EntityManagerInterface $em;
        private KernelInterface        $kernel;
        private StatisticsBridge       $bridge;
        private YamlReader             $yamlReader;


        public function __construct(
            TranslatorInterface    $translator,
            LoggerInterface        $logger,
            EntityManagerInterface $em,
            KernelInterface        $kernel,
            StatisticsBridge       $bridge,
            YamlReader             $yamlReader
        )
        {
            $this->translator = $translator;
            $this->logger = $logger;
            $this->em = $em;
            $this->kernel = $kernel;
            $this->bridge = $bridge;
            $this->yamlReader = $yamlReader;
        }


        /**
         * @Route("/back/test/stat", name="app_back_test_stat")
         * @throws Exception
         */
        public function index(): Response
        {
            $uniqueID = uniqid('', TRUE);
            $period = [
                'from' => new DateTime("2021/01/01 00:00:00"),
                'to'   => new DateTime("2022/05/30 00:00:00"),
            ];

            $class = 'App\\Services\\Platform\\BackOffice\\Statistics\\Export\\' . StatisticsBase::STAT_POINTS;
            if (!class_exists($class)) {
                throw new Exception('La classe ' . $class . ' n\'existe pas');
            }

            $statisticsClass = new $class($this->translator, $this->logger, $this->em, $this->kernel, $this->bridge, $this->yamlReader);
            $statisticsClass->createSheet($uniqueID, $period);

            return $this->render('back_test_stat/index.html.twig', [
                'controller_name' => 'BackTestStatController',
            ]);
        }

        /**
         * @Route("/back/test/script", name="app_back_test_script")
         * @throws Exception
         */
        public function insertIntoDatabase(){
            set_time_limit(0);
            ignore_user_abort(true);
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '-1');
            $path = '../tags.csv';
            $database = array();
            $i = 0;
            $type = ucfirst(pathinfo($path, PATHINFO_EXTENSION));

            $reader = IOFactory::createReader($type);
            $spreadsheet = $reader->load($path);
            $sheet = $spreadsheet->getActiveSheet();
            $lignes = $sheet->toArray();

            foreach ($lignes as $ligne) {
                $database[$i]['id'] = $ligne[0];
                $database[$i]['tag'] = $ligne[1] ?? "";
                $database[$i]['supplier_id'] = $ligne[2] ?? "";
                $i++;
            }
            $path = '../SupplierTag.csv';
            $database = array();
            $i = 0;
            $type = ucfirst(pathinfo($path, PATHINFO_EXTENSION));

            $reader = IOFactory::createReader($type);
            $spreadsheet = $reader->load($path);
            $sheet = $spreadsheet->getActiveSheet();
            $lignes = $sheet->toArray();
            $supplierTags = array();
            foreach ($lignes as $ligne) {
                $supplierTags[$i]['id'] = $ligne[0];
                $supplierTags[$i]['supplier_id'] = $ligne[1] ?? "";
                $supplierTags[$i]['tag_id'] = $ligne[2] ?? "";
                $supplierTags[$i]['weight'] = $ligne[3] ?? "";
                $i++;
            }
            $max = array_last_key($database);


            foreach ($supplierTags as $supplierTag){
                $line = null;
                if()
            }
//    for ($x = 0; $x <=$max; $x++){
//
//    }
        }
    }
