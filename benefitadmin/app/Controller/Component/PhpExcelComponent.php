<?php
App::uses('Component', 'Controller');

/**
 * Component for working with PHPExcel class.
 *
 * @package PhpExcel
 * @author segy
 */
class PhpExcelComponent extends Component {
    /**
     * Instance of PHPExcel class
     *
     * @var PHPExcel
     */
    protected $_xls;

    /**
     * Pointer to current row
     *
     * @var int
     */
    protected $_row = 1;

    /**
     * Internal table params
     *
     * @var array
     */
    protected $_tableParams;

    /**
     * Number of rows
     *
     * @var int
     */
    protected $_maxRow = 0;

    /**
     * Create new worksheet or load it from existing file
     *
     * @return $this for method chaining
     */
    public function createWorksheet() {
        // load vendor classes
        App::import('Vendor', 'PhpExcel', array('file' => 'PhpExcel/PHPExcel.php'));
        $this->_xls = new PHPExcel();
        $this->_row = 1;

        return $this;
    }

    /**
     * Create new worksheet from existing file
     *
     * @param string $file path to excel file to load
     * @return $this for method chaining
     */
    public function loadWorksheet($file) {
        // load vendor classes
        App::import('Vendor', 'PhpExcel', array('file' => 'PhpExcel/PHPExcel.php'));
        $this->_xls = PHPExcel_IOFactory::load($file);
        $this->setActiveSheet(0);
        $this->_row = 1;

        return $this;
    }

    /**
     * Add sheet
     *
     * @param string $name
     * @return $this for method chaining
     */
    public function addSheet($name) {
        $index = $this->_xls->getSheetCount();
        $this->_xls->createSheet($index)
            ->setTitle($name);

        $this->setActiveSheet($index);
        return $this;
    }

    /**
     * Set active sheet
     *
     * @param int $sheet
     * @return $this for method chaining
     */
    public function setActiveSheet($sheet) {
        $this->_maxRow = $this->_xls->setActiveSheetIndex($sheet)->getHighestRow();
        $this->_row = 1;

        return $this;
    }

    /**
     * Set worksheet name
     *
     * @param string $name name
     * @return $this for method chaining
     */
    public function setSheetName($name) {
        $this->_xls->getActiveSheet()->setTitle($name);

        return $this;
    }

    /**
     * Overloaded __call
     * Move call to PHPExcel instance
     *
     * @param string function name
     * @param array arguments
     * @return the return value of the call
     */
    public function __call($name, $arguments) {
        return call_user_func_array(array($this->_xls, $name), $arguments);
    }

    /**
     * Set default font
     *
     * @param string $name font name
     * @param int $size font size
     * @return $this for method chaining
     */
    public function setDefaultFont($name, $size) {
        $this->_xls->getDefaultStyle()->getFont()->setName($name);
        $this->_xls->getDefaultStyle()->getFont()->setSize($size);

        return $this;
    }

    /**
     * Set row pointer
     *
     * @param int $row number of row
     * @return $this for method chaining
     */
    public function setRow($row) {
        $this->_row = (int)$row;

        return $this;
    }

    /**
     * Start table - insert table header and set table params
     *
     * @param array $data data with format:
     *   label   -   table heading
     *   width   -   numeric (leave empty for "auto" width)
     *   filter  -   true to set excel filter for column
     *   wrap    -   true to wrap text in column
     *  bg_color - background color
     * @param array $params table parameters with format:
     *   offset  -   column offset (numeric or text)
     *   font    -   font name of the header text
     *   size    -   font size of the header text
     *   bold    -   true for bold header text
     *   italic  -   true for italic header text
     * @return $this for method chaining
     */
    public function addTableHeader($data, $params = array()) {
        // offset
        $offset = 0;
        if (isset($params['offset']))
            $offset = is_numeric($params['offset']) ? (int)$params['offset'] : PHPExcel_Cell::columnIndexFromString($params['offset']);

        // font name
       /* if(isset($params['title']) && !empty($params['title'])){
            $this->_row = $this->_row + 1;
        }*/
        if (isset($params['font']))
            $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setName($params['font']);

        // font size
        if (isset($params['size']))
            $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setSize($params['size']);

        // bold
        if (isset($params['bold']))
            $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setBold($params['bold']);

        // italic
        if (isset($params['italic']))
            $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setItalic($params['italic']);
        if(!isset($params['color']))
               $params['color'] = "00000";

       if(!isset($params['bg_color']))
               $params['bg_color'] = "FFFFFF";
        // set internal params that need to be processed after data are inserted
        $this->_xls->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->_xls->getActiveSheet()->getStyle($this->_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->_xls->getActiveSheet()->getStyle($this->_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $this->_xls->getActiveSheet()->getStyle($this->_row)->applyFromArray(array(
                                                            'fill' => array(
                                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                                //'color' => array('rgb' => $params['bg_color'])
                                                            ),
                                                            'font' => array(
                                                                'color' => array('rgb' => $params['color']),
                                                            )
                                                        ));
        $this->_tableParams = array(
            'header_row' => $this->_row,
            'offset' => $offset,
            'row_count' => 0,
            'auto_width' => array(),
            'auto_height' => array(),
            'filter' => array(),
            'wrap' => array(),
            'bg_color' => "FFFFFF",
            'color'=>"00000"
        );
        foreach ($data as $d) {
            // set label
            $this->_xls->getActiveSheet()->setCellValueByColumnAndRow($offset, $this->_row, $d['label']);
          
            if(isset($d['freez']) && !empty($d['freez'])){
                $this->_xls->getActiveSheet()->freezePaneByColumnAndRow($offset+1, $this->_row);
            }

            // set width
            if (isset($d['width']) && is_numeric($d['width']))
                $this->_xls->getActiveSheet()->getColumnDimensionByColumn($offset)->setWidth((float)$d['width']);
            else
                $this->_tableParams['auto_width'][] = $offset;
            //set Height 
            if(isset($d['height']) && !empty($d['height'])){
                $this->_xls->getActiveSheet()->getRowDimension(1)->setRowHeight((float)$d['height']);
            }else{
                $this->_tableParams['auto_height'] = 10;
            }
            // filter
            if (isset($d['filter']) && $d['filter'])
                $this->_tableParams['filter'][] = $offset;

            // wrap
            if (isset($d['wrap']) && $d['wrap'])
                $this->_tableParams['wrap'][] = $offset;

            //fill background color
            if(!empty($d['label'])){
                $this->_xls->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($offset) . ($this->_row) . ':' . PHPExcel_Cell::stringFromColumnIndex($offset) . ($this->_row + $this->_tableParams['row_count']))->getFill()->getStartColor()->setRGB($params['bg_color']);
            }
            $offset++;
        }

       /* if(isset($params['title']) && !empty($params['title'])){
            $titleRow = 1;
            $mergeCell = PHPExcel_Cell::stringFromColumnIndex(1) . ($titleRow) . ':' . PHPExcel_Cell::stringFromColumnIndex($offset) . $titleRow ;
            $this->_xls->getActiveSheet()->setCellValueByColumnAndRow(0,  $titleRow, $params['title']);
            $this->_xls->getActiveSheet()->getRowDimension($titleRow)->setRowHeight(30);
            $this->_xls->getActiveSheet()->getStyle("A1:K1")->applyFromArray(array(
                                                            'fill' => array(
                                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                                'color' => array('rgb' => $params['bg_color'])
                                                            ),
                                                            'font' => array(
                                                                    'color' => array('rgb' => $params['color']),
                                                                    'size' => 18
                                                                 )
                                                        ));
            $this->_xls->getActiveSheet()->getStyle("A1:K1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->_xls->getActiveSheet()->getStyle("A1:K1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
           $this->_xls->getActiveSheet()->mergeCells($mergeCell);
        }*/
        $this->_row++;

        return $this;
    }

    /**
     * Write array of data to current row
     *
     * @param array $data
     * @param array $data data with format:
     *   height   -   numeric (leave empty for "auto" height)
     * @return $this for method chaining
     */
    public function addTableRow($data, $param = array()) {
        $offset = $this->_tableParams['offset'];

        foreach ($data as $d){
            $this->_xls->getActiveSheet()->setCellValueByColumnAndRow($offset++, $this->_row, $d);
        }
        if(isset($param['height']) && !empty($param['height'])){
            $this->_xls->getActiveSheet()->getRowDimension($this->_row)->setRowHeight((float)$param['height']);
        }    

        $this->_row++;
        $this->_tableParams['row_count']++;
        return $this;
    }

    /**
     * End table - set params and styles that required data to be inserted first
     *
     * @return $this for method chaining
     */
    public function addTableFooter() {
        // auto width
        foreach ($this->_tableParams['auto_width'] as $col)
            $this->_xls->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);

        // filter (has to be set for whole range)
        if (count($this->_tableParams['filter']))
            $this->_xls->getActiveSheet()->setAutoFilter(PHPExcel_Cell::stringFromColumnIndex($this->_tableParams['filter'][0]) . ($this->_tableParams['header_row']) . ':' . PHPExcel_Cell::stringFromColumnIndex($this->_tableParams['filter'][count($this->_tableParams['filter']) - 1]) . ($this->_tableParams['header_row'] + $this->_tableParams['row_count']));

        // wrap
        foreach ($this->_tableParams['wrap'] as $col)
            $this->_xls->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col) . ($this->_tableParams['header_row']) . ':' . PHPExcel_Cell::stringFromColumnIndex($col) . ($this->_tableParams['header_row'] + $this->_tableParams['row_count']))->getAlignment()->setWrapText(true);

        return $this;
    }

    /**
     * Write array of data to current row starting from column defined by offset
     *
     * @param array $data
     * @return $this for method chaining
     */
    public function addData($data, $offset = 0) {
        // solve textual representation
        if (!is_numeric($offset))
            $offset = PHPExcel_Cell::columnIndexFromString($offset);

        foreach ($data as $d)
            $this->_xls->getActiveSheet()->setCellValueByColumnAndRow($offset++, $this->_row, $d);

        $this->_row++;

        return $this;
    }

    /**
     * Get array of data from current row
     *
     * @param int $max
     * @return array row contents
     */
    public function getTableData($max = 100) {
        if ($this->_row > $this->_maxRow)
            return false;

        $data = array();

        for ($col = 0; $col < $max; $col++)
            $data[] = $this->_xls->getActiveSheet()->getCellByColumnAndRow($col, $this->_row)->getValue();

        $this->_row++;

        return $data;
    }

    /**
     * Get writer
     *
     * @param $writer
     * @return PHPExcel_Writer_Iwriter
     */
    public function getWriter($writer) {
        return PHPExcel_IOFactory::createWriter($this->_xls, $writer);
    }

    /**
     * Save to a file
     *
     * @param string $file path to file
     * @param string $writer
     * @return bool
     */
    public function save($file, $writer = 'Excel2007') {
        $objWriter = $this->getWriter($writer);
        return $objWriter->save($file);
    }

    /**
     * Output file to browser
     *
     * @param string $file path to file
     * @param string $writer
     * @return exit on this call
     */
    public function output($filename = null, $writer = 'CSV') {
        ob_end_clean();

        // headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // writer
        $objWriter = $this->getWriter($writer);
        $objWriter->save('php://output');

        exit;
    }

    /**
     * Free memory
     *
     * @return void
     */
    public function freeMemory() {
        $this->_xls->disconnectWorksheets();
        unset($this->_xls);
    }
}