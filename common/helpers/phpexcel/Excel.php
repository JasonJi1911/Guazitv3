<?php
/**
 * Excel文件操作
 * @update 自动加载支持
 */
namespace common\helpers\phpexcel;
require_once dirname(__FILE__) . '/PHPExcel.php';

class Excel extends \PHPExcel {
	/**
	 * 简单导出数据
	 * @author bandry
	 * @param Array $data
	 * $param string $filename 输出的文件名
	 */
	public static function exportSimple($data, $filename = '数据.xls') {
		\PHPExcel_Settings::setCacheStorageMethod(\PHPExcel_CachedObjectStorageFactory::cache_to_discISAM);
		$objPHPExcel = new \PHPExcel();
		$sheet = $objPHPExcel->setActiveSheetIndex(0);
		$colindex = 0;
		$rownum = 1;
		foreach ($data as $rowdata) {
			$colindex = 0;
			foreach ($rowdata as $coldata) {
				$cellname = self::getColName($colindex) . $rownum;
				if (strlen($coldata) > 10) {
					$sheet->setCellValueExplicit($cellname, $coldata, \PHPExcel_Cell_DataType::TYPE_STRING);
					$sheet->getStyle($cellname)->getNumberFormat()->setFormatCode("@");
				} else {
					$sheet->setCellValue($cellname, $coldata);
				}
				//$sheet->setCellValueByColumnAndRow($colindex, $rownum, $coldata);
				$sheet->getColumnDimensionByColumn($colindex)->setWidth(21.25 + 0.71);
				$colindex++;
			}
			$rownum++;
		}
		if (strpos($filename, 'xls') === false) {
			$filename .= '.xls';
		}
		self::output($filename, $objPHPExcel);
	}
	/**
	 * 将数据已excel的形式导出
	 * @param string $filename 文件名，不包含后缀
	 * @param array $data (array(
	 * 'title'=>'title',
	 * 'data'=>array(),
	 * 'header'=>array(n=>w,n2=>w2),
	 * 'stat'=>array(row1,row2,col1, col2),
	 * 'freeze'=>'C2',
	 *  ...)
	 */
	public static function exportData($filename, $data) {
		\PHPExcel_Settings::setCacheStorageMethod(\PHPExcel_CachedObjectStorageFactory::cache_to_discISAM);

		$objPHPExcel = new \PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("宜生到家")
			->setLastModifiedBy("宜生到家")
			->setTitle($filename)
			->setSubject($filename)
			->setDescription($filename)
			->setKeywords($filename)
			->setCategory($filename);

		$sheetindex = 0;
		$styleArray = array(
				'borders' => array(
						'allborders' => array(
								'style' => \PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => '000000'),
						),
				),
		);
		foreach ($data as $sheetdata) {
			$title = $sheetdata['title'];
			$datalist = $sheetdata['data'];
			if ($sheetindex > 0) {
				$sheet = $objPHPExcel->createSheet($sheetindex);
			} else {
				$sheet = $objPHPExcel->setActiveSheetIndex($sheetindex);
			}
			$sheetindex++;

			$sheet->getDefaultColumnDimension()->setWidth(16.71);
			$sheet->getDefaultRowDimension()->setRowHeight(21);
			if (isset($sheetdata['width'])) {
				foreach ($sheetdata['width'] as $k=>$width) {
					$sheet->getColumnDimensionByColumn($k)->setWidth($width+0.71);
				}
			}

			$sheet->setTitle($title);
			$rownum = 1;
			$columncnt = 0;
			if (isset($sheetdata['header'])) {
				$colindex = 0;
				foreach ($sheetdata['header'] as $coltitle=>$colwidth) {
					$sheet->setCellValueByColumnAndRow($colindex, $rownum, $coltitle);
					$sheet->getStyleByColumnAndRow($colindex, $rownum)->getFont()->setBold(true);
					$sheet->getColumnDimensionByColumn($colindex++)->setWidth($colwidth+0.71);
					if (strpos($coltitle, '税后') !== false) {
						$cellname = self::getColName($colindex-1);
						$sheet->getStyle($cellname.'1:'.$cellname.count($datalist))->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
						$sheet->getStyle($cellname.'1:'.$cellname.count($datalist))->getFill()->getStartColor()->setARGB('FFF2DCDB');
					}
				}
				$rownum++;
			}
			$maxcolnum = 0;
			foreach ($datalist as $rowdata) {
				// 高度21
				if (count($rowdata) < 1) {
					$rownum++;
					continue;
				}
				$maxcolnum = count($rowdata) > $maxcolnum ? count($rowdata) : $maxcolnum;
				\yoka\Debug::log($rownum, $maxcolnum);
				$colindex = 0;
				foreach ($rowdata as $coldata) {
					$cellname = self::getColName($colindex++) . $rownum;

					if (strlen($coldata) > 10) {
						$sheet->setCellValueExplicit($cellname, $coldata, \PHPExcel_Cell_DataType::TYPE_STRING);
						$sheet->getStyle($cellname)->getNumberFormat()->setFormatCode("@");
					} else {
						$sheet->setCellValue($cellname, $coldata);
					}
					if ($rownum == 1) {
						$sheet->getStyle($cellname)->getFont()->setBold(true);
					}
					//$sheet->getStyle($cellname)->applyFromArray($styleArray);
				}
				$rownum++;
			}

			if (isset($sheetdata['freeze'])) {
				$sheet->freezePane($sheetdata['freeze']);
			}
			try {
				$cellname = self::getColName($maxcolnum-1) . ($rownum-1);
				$sheet->getStyle('A1:' . $cellname)->applyFromArray($styleArray);
			} catch (\Exception $ex) {
				//
			}
		}

		// 将第一个sheet设为活动的
		$objPHPExcel->setActiveSheetIndex(0);

		$filename .= '.xls';
		self::output($filename, $objPHPExcel);
	}
	/**
	 * 输出
	 * @param unknown $filename
	 * @param unknown $objPHPExcel
	 */
	public static function output($filename, $objPHPExcel) {
		if(isset($_REQUEST['debug'])){
			//直接显示
		}else{
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			header('Cache-Control: max-age=1');
		}
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		exit;
	}
	/**
	 * 根据索引值，获取 excel的列名，比如 0=>A, 1=>'B', ... 26=>'AA'
	 * @param int $index
	 */
	public static function getColName($index) {
		$hight = floor($index/26); // 大于1则超出A-Z范围了
		$lower = $index % 26; // 0-25
		$str = chr(65 + $lower);
		if ($hight > 0) {
			$str = chr(65+$hight-1) . $str;
		}
		return $str;
	}
	/**
	 * 将数据组装成一个sheet的结构，避免出现下标不一致的情况
	 * 也可以自己组装，下标 title和data是固定的
	 * @param string $title
	 * @param array $data
	 * @return multitype:unknown
	 */
	public static function createSheetData($title, $data, $header) {
		return array('title'=>$title, 'data'=>$data, 'header'=>$header);
	}

	/**
	 * by JC.2016.10.16
	 * 快速简单导入Excel数据为数组的方法
	 * ifCellExist  param  是否读取值为空的单元格
	 */
	public static function readExcel($file, $ifCellExist = false) {
		$excelObj = \PHPExcel_IOFactory::load($file);

		$ifCellExist = $ifCellExist?true:false;

		$rowIterator = $excelObj->getActiveSheet()->getRowIterator();
		foreach ($rowIterator as $v) {
			$cellIterator = $v->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells($ifCellExist);
			$rowIndex = $v->getRowIndex();
			$item = [];
			foreach ($cellIterator as $cell) {
				$flag .= $cell->getValue();
				$item[] = $cell->getValue();
			}
			if ($flag) {
				foreach($item as $k=>$v){
					if(is_object($v)){
						$item[$k] = $v->getPlainText();
					}
				}
				$re[] = $item;
			}
			$flag = '';
		}

		return $re;
	}

    /**
     * excel导出 支持多个sheet,单元格合并
     * @author zhangqiang
     *
     * @param $data //sheet数据数组
     * 【注意: 格式多个sheet对应多个数组 】
     * 格式:
     *  单个sheet [ 0 => $list]
     *  多个sheet [ 0 => $list,1 => $list,2 => $list]
     *
     *  @$filename 文件名
     *
     *  @param $conf //对应多个sheet的配置
     *  【注意:优先级 mergeMore 比 merge 高】
     * 格式:
     *  $conf = [
     *       0 => [
     *           'title' => '订单数据',
     *           'merge' => ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q'],
     *           'mergeMore' => ['A1:A2','B1:B2','C1:F1'],
     *       ]
     *  ];
     *  @subparam  merge 连续单元格合并
     *  @subparam  mergeMore 非连续单元格合并
     *
     * @$savePath 是否保存文件 默认不保存,直接下载
     * 如果保存为文件,传入要保存的路径
     */
    public static function exportMoreData($data,$filename,$conf,$savePath=[]) {
        \PHPExcel_Settings::setCacheStorageMethod(\PHPExcel_CachedObjectStorageFactory::cache_to_discISAM);

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator('宜生到家')//设置创建者
        ->setLastModifiedBy('宜生到家')//设置时间
        ->setTitle($filename)//设置标题
        ->setSubject($filename)//设置备注
        ->setDescription($filename)//设置描述
        ->setKeywords($filename)//设置关键字 | 标记
        ->setCategory($filename);//设置类别

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
        );

        $indexKey = 0;
        foreach ($data as $rowdata) {
            if($indexKey > 0){
                $sheet = $objPHPExcel->createSheet($indexKey);
                if(isset($conf[$indexKey]['title'])){
                    $sheet->setTitle($conf[$indexKey]['title']);
                }
            }else{
                $sheet = $objPHPExcel->setActiveSheetIndex($indexKey);
                if(isset($conf[$indexKey]['title'])){
                    $sheet->setTitle($conf[$indexKey]['title']);
                }
            }
            $sheet->getDefaultStyle()->getFont()->setName('宋体');
            $sheet->getDefaultStyle()->getFont()->setSize(12);
            $sheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $rownum = 1;
            foreach ($rowdata as $coldata) {
                $colindex = 0;
                foreach ($coldata as $value){
                    $sheet->setCellValueByColumnAndRow($colindex, $rownum, $value);
                    //$sheet->getColumnDimension('E')->setWidth(30);
                    $colindex++;
                }
                $rownum++;
            }
            $cellname = self::getColName($colindex-1) . $rownum;

            //不同的位置分别合并单元格  格式 ['A1:F1', 'A3:C3'];
            $mergeMore = isset($conf[$indexKey]['mergeMore'])?$conf[$indexKey]['mergeMore']:[];
            if($mergeMore){
                foreach ($mergeMore as $cell) {
                    $sheet->mergeCells($cell);
                }
            }else{
                //连续的合并单元格 格式 ['A','B','C'];
                $merge = array();
                $cell_start = $cell_end = 0;
                $cnt = count($rowdata);
                foreach ($rowdata as $key => $val) {
                    if ($val[0] == '') {
                        $cell_end++;
                        if ($cnt-1 == $key) $merge[] = $cell_start . '-' . $cell_end; //最后一个为空，则合并
                    } else {
                        if ($cell_start != $cell_end) $merge[] = $cell_start . '-' . $cell_end;
                        $cell_start = $cell_end = $cell_end + 1;
                    }
                }
                $merges = isset($conf[$indexKey]['merge'])?$conf[$indexKey]['merge']:[];
                if($merges){
                    foreach ($merges as $key => $v) {
                        foreach ($merge as $k => $cell) {
                            $arr_cell = explode('-', $cell);
                            $mer_cell = $v . $arr_cell[0] . ':' . $v . $arr_cell[1];
                            $sheet->mergeCells($mer_cell);
                        }
                    }
                }
            }
            //设置样式
            if(isset($conf[$indexKey]['style'])){
                $style = $conf[$indexKey]['style'];
                foreach ($style as $styleKey => $info){
                    //背景色
                    if($styleKey == 'bg'){
                        foreach ($info as $cellKey => $st){
                            $objPHPExcel->getActiveSheet($indexKey)->getStyle($cellKey)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet($indexKey)->getStyle($cellKey)->getFill()->getStartColor()->setRGB($st);
                        }
                    }elseif($styleKey == 'font_size'){
                        //字体
                        foreach ($info as $cellKey => $st){
                            $objPHPExcel->getActiveSheet($indexKey)->getStyle($cellKey)->getFont()->setSize($st);
                        }
                    }elseif($styleKey == 'column_width'){
                        //列宽
                        foreach ($info as $cellKey => $st){
                            $sheet->getColumnDimension($cellKey)->setWidth($st);
                        }
                    }elseif($styleKey == 'img'){
                        //插入图片
                        foreach ($info as $cellKey => $st){
                            //$sheet->setSize($st['coord'],20,20);
                            if($st['img']){
                                $rowKey = substr($st['coord'],1,strlen($st['coord']) - 1);
                                $sheet->getRowDimension($rowKey)->setRowHeight(100);
                                $imgResource = getimagesize($st['img']);
                                $imgType = [2 => 'imagecreatefromjpeg',3 => 'imagecreatefrompng'];
                                //图片资源
                                $img = $imgType[$imgResource[2]]($st['img']);
                                $objDrawing = new \PHPExcel_Worksheet_MemoryDrawing();
                                $objDrawing->setResizeProportional(false);
                                $objDrawing->setCoordinates($st['coord']);
                                $objDrawing->setImageResource($img);
                                $objDrawing->setName($st['img']);
                                $objDrawing->setWidth(120);
                                $objDrawing->setHeight(120);
                                $objDrawing->setOffsetX(5);
                                $objDrawing->setOffsetY(5);
                                $objDrawing->setRenderingFunction(\PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);//渲染方法
                                $objDrawing->setMimeType(\PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_JPEG);
                                $objDrawing->setWorksheet($sheet);//同上
                            }

                        }
                    }
                }
            }
            //设置border
            $objPHPExcel->getActiveSheet($indexKey)->getStyle('A1:'.$cellname)->applyFromArray($styleArray);
            $indexKey++;
        }
        $filename .= '.xls';
        if ($savePath){
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            if(!is_dir($savePath['tmpDir'])){
                @mkdir($savePath['tmpDir'],0757);
            }
            $objWriter->save($savePath['tmpFile']);
            return true;
        }else{
            self::output($filename, $objPHPExcel);
        }
    }

    /**
     * excel在线预览
     * @param $file
     */
    public static function viewExcel($file){
        if(!$file) return '';
        $objReader = new \PHPExcel_Reader_Excel2007();
        $objWriteHtml = new \PHPExcel_Writer_HTML($objReader->load($file));
        $objWriteHtml->save('php://output');
        echo "<style>img{position:unset !important}td.style1{border:1px solid #999999 !important}td.style2{border:1px solid #999999 !important}td.style3{border:1px solid #999999 !important}</style>";
    }
}
