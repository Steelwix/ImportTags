<?php
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
