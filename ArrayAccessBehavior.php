<?php
class ArrayAccessBehavior extends Behavior
{
	public function objectMethods()
	{
		$script = '';
		$script .= $this->addArrayAccessGetter();
		$script .= $this->addArrayAccessSetter();
		$script .= $this->addArrayAccessUnsetter();
		$script .= $this->addArrayAccessIssetChecker();
		return $script;
	}
	
	public function objectFilter(&$script)
	{
		$pattern = '/abstract class (\w+) extends (\w+)  implements (\w+)/i';
		$replace = 'abstract class ${1} extends ${2}  implements ${3}, ArrayAccess';
		$script = preg_replace($pattern, $replace, $script);
	}
	
	protected function addArrayAccessIssetChecker()
	{
		return "
public function offsetExists(\$offset)
{
	return \$this->getByName(\$offset) !== null;
}
";
	}
	
	protected function addArrayAccessGetter()
	{
		return "
public function offsetGet(\$offset)
{
	return \$this->getByName(\$offset);
}
";
	}
	
	protected function addArrayAccessUnsetter()
	{
		return "
public function offsetUnset(\$offset)
{
	\$this->setByName(\$offset, null);
}
";
	}
	
	protected function addArrayAccessSetter()
	{
		return "
public function offsetSet(\$offset, \$value)
{
	\$this->setByName(\$offset, \$value);
}
";
	}
}