<?php
class Zendvn_Models_UserOnline extends Zend_Db_Table
{
	protected $_name = 'user_online';
	protected $_primary = 'id';
	
	public function counter()
	{
		$session=session_id();
		$time =time();
		$time_check =$time-60;
		
		$select=$this->select()
				   	 ->where('session=?',$session);
		
		$result=$this->fetchRow($select);
		
		if(empty($result))
		{
			$row=$this->fetchNew();
			$row->session =$session;
			$row->time    =$time;
			$row->save();
		}else 
		{
			$where  ='session = '.$session;
			$row	=$this->fetchRow($select);
			$row->time=$time;
			$row->save();
		}
		
		$where	= 'time < ' . $time_check;
		$this->delete($where);	
				  
		
		$rows	=$this->fetchAll()->toArray();
		return count($rows);
		
	}
}

