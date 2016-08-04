<?php
namespace Admin\Controller;
use Think\Controller;


class PerformanceController {
  public function index(){
    function bar($x) {
      if ($x > 0) {
          bar($x - 1);
      }
    }

    function foo() {
        for ($idx = 0; $idx < 5; $idx++) {
          bar($idx);
          $x = strlen("abc");
      }
    }

    //开启调试
    xhprof_enable();
    // cpu:XHPROF_FLAGS_CPU 内存:XHPROF_FLAGS_MEMORY
    // 如果两个一起：XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY 
    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

    //要测试的php代码
    foo();

    //停止监测
    $xhprof_data = xhprof_disable();

    // display raw xhprof data for the profiler run
    print_r($xhprof_data);

    //包含工具类，在下载的 tgz 包中可以找到
    //$XHPROF_ROOT = realpath(dirname(__FILE__) .'/..');
    Vendor('Xhprof.autoload');
    //Vendor('Xhprof.xhprof_runs');
    //include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
    //include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

    // save raw data for this profiler run using default
    // implementation of iXHProfRuns. 

    }
}