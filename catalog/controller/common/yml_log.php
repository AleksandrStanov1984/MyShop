<?php
class ControllerCommonYmlLog extends Controller{
    public function index(){
        $arr = file(DIR_LOGS . "import_yml.log");
        $count = 0;
        $search =  date('Y-m-d'); //2021-01-20
        foreach ( $arr as $v ){
            if ( strpos($v,$search,0) !==false ){
                $count++;
            }
        }
           echo $count;
    }
}
