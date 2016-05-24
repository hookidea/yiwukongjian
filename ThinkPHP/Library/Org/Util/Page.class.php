<?php
namespace Org\Util;
/**
 * @Role:   分页类
 * @Author: hookidea
 * @Date:   2015-11-30 08:37:47
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-26 22:25:53
 */
/**
 * $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);      $pagesize+1：此处必须+1
 */
class Page
{
	private $listRows;   // 一页显示的条数
	private $showGo;   // 一页显示的条数
	private $ord;        // 从第一页显示还是最后一也显示
	private $pageNum;    // 总页数
	private $page;       // 当前页数
	private $query_args; //传递的参数
	private $uri;        // 保存没有page的URL
	private $limit;      // 保存limit
	private $config = array(
		'first'=>'首页',  
		'last'=>'末页',
		'prev'=>'上一页',
		'next'=>'下一页'
		);

	/**
	 * 构造函数
	 * @param integer       $listRows 一页显示的条数，默认10条
	 * @param boolean       $showGo   是否需要go
	 * @param string/array  $query    要传递的参数
	 */
	public function __construct($listRows=10, $showGo=true, $args=''){
		$this->page = $_GET['p'] ? $_GET['p'] : 1;      // 当前页码
		$this->listRows = $listRows;   // 一页显示的条数
		$this->showGo = $showGo;
		$this->_parseUrl($args);        // 解析URL
		$this->limit = $listRows*($this->page-1) . ',' . (string)($listRows+1);
	}

	/**
	 * 设置类属性
	 * @param array $config  如：array('last'=>尾页)，仅能设置$config属性
	 */
	public function set($config){
		$config = array_change_key_case($config);
		$keys = array_keys($this->config);
		foreach($config as $k=>$v) {
			if (in_array($k, $keys)) $this->config[$k] = $v;
		}
	}

	/**
	 * 生成分页代码
	 * @param  integer  $list   数据列表（注意：必须比实际想要的条数 + 1，即count($list)-1 = $listRows
	 * @return string   分页代码
	 */
	public function show(&$list){
		if (empty($list)) return '';
		
		$len = count($list);

		$go = $this->showGo ? $this->_go() : '';

		if ($this->page == 1) {
			if ($len > $this->listRows) { // 有下一页
				array_pop($list);  // 删除多余的那一个
				return $this->_lastNext() . $go;
			}
			
		} else {
			if ($len > $this->listRows) { // 有下一页
				array_pop($list);  // 删除多余的那一个
				return $this->_firstPrev() . $this->_lastNext() . $go;
			} else { // 没有下一页
				return $this->_firstPrev() . $go;
			}
		}
		
	}

	//为：$page->limit, $page->page; 提供支持
	public function __get($name){
		$name = strtolower($name);
		return $name == 'limit' || $name == 'page' ? $this->$name : null;
	}

	//跳转
	private function _go(){
		$str = '<input type="text" onkeydown="javascript:if (event.keyCode==13) {var page=this.value;location.href=\''.$this->uri.'&p=\'+page;}" style="width:25px;"><input type="button" onclick="javascript:var page=this.previousSibling.value;location.href=\''.$this->uri.'&p=\'+page;" value="Go">';
		return $str;
	}

	//上一页、首页
	private function _firstPrev(){
		$prev = $this->page-1;
		$str = "<a class='first' href=\"{$this->uri}&p=1\">{$this->config['first']}</a>";
		$str .= "<a class='prev' href=\"{$this->uri}&p={$prev}\">{$this->config['prev']}</a>";
		return $str;
	}

	//下一页
	private function _lastNext(){
		$next = $this->page+1;
		$str = "<a class='next' href=\"{$this->uri}&p={$next}\">{$this->config['next']}</a>";
		return $str;
	}

	/**
	 * 解析URL，得到当前页数，并得到没有page的url地址
	 * @param  string/array  $args   要传递的query参数
	 */
	private function _parseUrl($args){
		$url = $_SERVER['REQUEST_URI'];
		if (is_array($args))
			$query_args = http_build_query(array_diff($args, $_GET));
		elseif(!empty($args))
			$query_args = strpos($url, $args) !== false ? '' : $args;
		else
			$query_args = '';
		$parse = parse_url($url);
		$path = $parse['path'];
		if (!isset($parse['query'])) {
			$this->uri = $path . '?' . $query_args;
			return;
		}
		$query = $parse['query'];
		$query_arr = explode('&', $query);
		for($i=0, $len=count($query_arr); $i<$len; $i++){
			$tmp = explode('=', $query_arr[$i]);
			if (strtolower($tmp[0]) == 'p') {
				$this->page = $tmp[1];
				unset($query_arr[$i]);
			}
		}
		if (!is_numeric($this->page)) $this->page = 1;
		$this->uri = $path . '?' . implode('&', $query_arr) . $query_args;
	}
}


// $page = new Page(555, 10, 'id=3&kk=3');
// $page->set(array('head'=>'条'));

// $mysqli = new mysqli('localhost', 'root', 'addmim', 'test');
// $result = $mysqli->query('select * from t2 ' . $page->limit);
// echo '<table>';
// while($row=$result->fetch_assoc()){
// 	echo "<tr><td>{$row['id']}</td><td>{$row['title']}</td><td>{$row['name']}</td></tr>";
// }
// echo '</table>';

// echo $page->getPage();
