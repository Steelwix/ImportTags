        public function script()
        {
            set_time_limit(0);
            ignore_user_abort(true);
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '-1');
            $path = $this->projectDir . '/ProductExtract.csv';
            $i = 0;
            $type = ucfirst(pathinfo($path, PATHINFO_EXTENSION));

            $reader = IOFactory::createReader($type);
            $spreadsheet = $reader->load($path);
            $sheet = $spreadsheet->getActiveSheet();
            $lignes = $sheet->toArray();

            foreach ($lignes as $ligne) {
                $products[$i]['id'] = $ligne[0];
                $products[$i]['name'] = $ligne[1] ?? "";
                $products[$i]['weight'] = $ligne[2] ?? "";
                $products[$i]['height'] = $ligne[3] ?? "";
                $products[$i]['width'] = $ligne[4] ?? "";
                $products[$i]['length'] = $ligne[5] ?? "";
                $products[$i]['property'] = $ligne[6] ?? "";
                $products[$i]['value'] = $ligne[7] ?? "";
                $i++;
            }
            dd($products);
        }
