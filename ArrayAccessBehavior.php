<?php

/**
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

/**
 * The main class for the Behavior
 *
 * @author     Niklas Närhinen <niklas@narhinen.net>
 */
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
	try {
		\$getter = 'get' . \$offset;
		return \$this->\$getter() !== null;
	}
	catch (PropelException \$ex) {
		return false;
	}
}
";
	}
	
	protected function addArrayAccessGetter()
	{
		return "
public function offsetGet(\$offset)
{
	\$getter = 'get' . \$offset;
	return \$this->\$getter();
}
";
	}
	
	protected function addArrayAccessUnsetter()
	{
		return "
public function offsetUnset(\$offset)
{
	try {
		\$setter = 'set' . \$offset;
		\$this->\$setter(null);
	}
	catch (PropelException \$ex) { }
}
";
	}
	
	protected function addArrayAccessSetter()
	{
		return "
public function offsetSet(\$offset, \$value)
{
	\$setter = 'set' . \$offset;
	\$this->\$setter(\$value);
}
";
	}
}