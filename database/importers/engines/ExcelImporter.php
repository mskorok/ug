<?php

namespace Database\Importers\Engines;

use App\Helpers\ImageFaker;
use Carbon\Carbon;
use Exception;
use PHPExcel_IOFactory;
use Faker\Factory;

class ExcelImporter
{
    protected $file = null;

    protected $reader = null;

    protected $faker  = null;
    protected $imgFaker = null;
    protected $carbon = null;

    public function __construct()
    {
        if ($this->file === null) {
            throw new Exception('Class extending ExcelImporter must have $file property defined');
        }

        $this->faker = Factory::create('de_DE');
        $this->imgFaker = new ImageFaker();
        $this->carbon = new Carbon;

        $inputFileName = $this->getDataPath($this->file);
        /**  Identify the type of $inputFileName  **/
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a PHPExcel Object  **/
        $this->reader = $objReader->load($inputFileName);
    }

    protected function getDataPath($file = null)
    {
        $path = database_path() . '/importers/data/';
        if ($file !== null) {
            $path = $path . $file;
        }
        return $path;
    }

    /**
     * Get spreadsheet document cells containing value as simple list (array) or a 2D array
     * Ignores first row
     * Empty cells = null
     * First cell in row/column (depending on $iterate_by_row) must not be empty or full row/column will be ignored
     * Caches result for each $sheet_index, useful to call same Importer from multiple seeders
     *
     * @param int $sheet_index = 0
     * @param bool $iterate_by_row = true (true - read doc by rows, false - read doc by columns)
     * @param bool $multidimensional_array = true (true - return a 2D array, false - return a simple array
     * @return array
     */
    public function parseData($sheet_index = 0, $iterate_by_row = true, $multidimensional_array = true)
    {
        if (isset(static::$cache[$sheet_index])) {
            return static::$cache[$sheet_index];
        }

        $data = [];

        $worksheet = $this->reader->setActiveSheetIndex($sheet_index);

        if ($iterate_by_row) {
            $k = -1; // ignoring first row
            $iterator = $worksheet->getRowIterator();
        } else {
            $iterator = $worksheet->getColumnIterator();
            $k = 0;
        }

        foreach ($iterator as $collection) {
            $cellIterator = $collection->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set

            $i = 0;

            foreach ($cellIterator as $cell) {
                $row_nr = $cell->getRow();
                if ($row_nr > 1) {
                    if (!is_null($cell)) {
                        $val = $cell->getValue();

                        if (!isset($data[$k]) && $val === null) {
                            // 1st cell in collection is empty, ignore whole row/column - do nothing
                            // this is needed to avoid returning a big array without real values
                        } else {

                            if (isset($this->columns)) {
                                if (isset($this->columns[$i])) {
                                    $name = $this->columns[$i];
                                } else {
                                    $name = null;
                                }
                            } else {
                                $name = $i;
                            }

                            if ($name !== null) {

                                if ($multidimensional_array) {
                                    $data[$k][$name] = $this->callback($row_nr-1, $i, $val);
                                } else {
                                    if ($val !== null) {
                                        $data[] = $this->callback($row_nr-1, $i, $val);
                                    }
                                }

                            }

                        }
                    }
                    $i++;
                }

            }
            $k++;
        }

        static::$cache[$sheet_index] = $data;
        return $data;
    }

    public function clearCache()
    {
        static::$cache = [];
    }

    public function getCSIDs($val)
    {
        return array_map(
            function ($v) {
                return intval($v);
            },
            explode(',', $val)
        );
    }

    private function callback($record_nr, $col_index, $val)
    {
        $method = 'callback'.$col_index;
        if (method_exists($this, $method)) {
            return $this->$method($val, $record_nr);
        } else {
            if ($val === null) {
                return '';
            } else {
                return $val;
            }
        }
    }
}
