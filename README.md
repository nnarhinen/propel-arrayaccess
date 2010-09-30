Propel ORM ArrayAccess behavior
===============================
Usage
-----
### build.properties

	propel.behavior.arrayaccess.class = path.to.ArrayAccessBehavior

### schema.xml

	<database name="tallimestari" defaultIdMethod="native">
		<behavior name="arrayaccess" />
		....
	</database>