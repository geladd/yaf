<?php

/**
 * geladd
 * 2017-11-21
 */
class Pagination {
	/**
	 * 生成分页
	 *
	 * @param     $_total 总记录数
	 * @param     $_pagesize 每页显示的条目数
	 * @param     $bothnum 当前页前后间隔数
	 * @param     $url url地址
	 *
	 * @return mixed
	 */
	public static function splite($_total, $_pagesize, $bothnum, $url, $view) {
		$total    = $_total;
		$pagesize = $_pagesize;
		$pagenum  = ceil($total / $pagesize);
		if(!empty($_GET['page'])){
		    if($_GET['page'] > 0){
		        if($_GET['page'] < $pagenum){
		            $page = $_GET['page'];
		        }else{
		            $page = $pagenum;
		        }
		    }else{
		        $page = 1;
		    }
		}else{
		    $page = 1;
		}
		
		//首页
		if($page > 1) {
		    $_page .= '<a href="'.$url.'&page=1">首页</a>';
		}
		
		//上一页
		$_page .= '<a href="'.$url.'&page='.($page-1).'">上一页</a>';
		
		for($i=($page - $bothnum);$i<$page;$i++){
		    if($i < 1) continue;
		    $_page .= '<a href="'.$url.'&page='.$i.'"  title="">'.$i.'</a>';
		}
		$_page .= '<span class="me">'.$page.'</span>';
		
		for($i=($page+1);$i<=($page + $bothnum);$i++){
		    if($i > $pagenum) break;
		    $_page .= '<a href="'.$url.'&page='.$i.'"  title="">'.$i.'</a>';
		}
		
		//下一页
		$_page .= '<a href="'.$url.'&page='.($page+1).'">下一页</a>';
		
		//尾页
		if($page < $pagenum) {
		    $_page .= '<a href="'.$url.'&page='.$pagenum.'">尾页</a>';
		}
		
		if($pagenum > 1) {
            $view->assign('pager', $_page);
        }
	}
}
