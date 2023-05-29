

@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

<div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
        <div class="font-em-1d2">

            @lay('build.co.links:tutor_pointer')

            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Database : Migrations Samples</div> <br>

                <div class="pxs-6">
                    Migration files can be used for creating, modifying database tables. In these tutorial, we will see 
                    how to create and alter database tables using the migration files.
                </div> <br>

                <div class="">

                    <div class="migration-files">
                        <div class="c-olive">Creating and dropping a database table.</div>

                        <div class="d87 mvs-4">
                            Assuming we want to generate a database table "users", we can do this by running the following commands:
                        </div>

                        <div class="pre-area mvs-20">
 <pre class="pre-code">
  php mi add:migrator create_users 
 </pre>
                        </div> <br>

                        <div class="foot-note">
                            Using the syntax above, the "users" migration file will be added to the migration folder in the following format:
                        </div><br>

                        <div class="box-full  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example : Migration file sample</div>
                    <pre class="pre-code">
  &lt;?php 

    class M1673742992_create_users {


        function up() {

            DBSHEMA::CREATE($this, function(DRAFT $DRAFT){

                <span class="comment">//$DRAFT::VARCHAR();</span>

            })

        } 

        function down() {

            DBSCHEMA::ALTER($this, function(DRAFT $DRAFT){

                <span class="comment">//$DRAFT::DROP();</span>
                
            })

        }

        function tablename() : string {

            return 'users';

        }


    }
                    </pre>
                        </div> <br><br>

                        <div class="d87">
                            The structure above resembles a full format of a migration file. While the <code>up()</code> 
                            and <code>down()</code> methods are essential, the <code>tablename()</code> method is is optional. The 
                            <code>tablename()</code> function makes it easier to work with the same table name in the <code>DBSCHEMA</code> 
                            environment. This is the reason it is much easier to run the <code>DBSCHEMA::CREATE($this)</code>. In the event that the 
                            <code>tablename()</code> method is not supplied, then we can only supply the table name by using the 
                            <code>DBSCHEMA::CREATE('table_name')</code> instead. This also applies to the <code>DBSCHEMA::ALTER()</code> function.

                            <p>
                                In the code above, because a name of <code>create_</code> was prefixed to <code>users</code>, the migration file generator 
                                will assume that a table name <code>"users"</code> is intended to be used. Hence, the default <code>tablename()</code> will be set as "users". 
                                This format is also used when <code>alter_</code> directive name is employed.
                            </p>

                            <p>
                                From the format above, we can easily generate a table name by using the data type methods as shown below:
                            </p>
                        </div> <br>

                        <div class="box-full  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example : Creating migration table for users table</div>
                    <pre class="pre-code">
  &lt;?php 

    class M1673742992_create_users {


        function up() {

            DBSHEMA::CREATE($this, function(DRAFT $DRAFT){

                $DRAFT::INT('id', '100');

                $DRAFT::VARCHAR('firstname', '100');

                $DRAFT::VARCHAR('lastname', '100');

                $DRAFT::VARCHAR('email', 200)->UNIQUE()->NOT_NULL();

                $DRAFT::VARCHAR('password', 200)->UNIQUE()->NOT_NULL();

                $DRAFT::VARCHAR('phone', 20)->UNIQUE()->NOT_NULL();

                $DRAFT::TEXTFIELD('LONG', 'biodata')->NOT_NULL();

                $DRAFT::DATETIME('added_on', '(CURRENT_TIMESTAMP)');

                $DRAFT->PRIMARY_KEY('id')->AUTO_INCREMENT();  

                return $DRAFT;

            })

        } 

        function down() {

            DBSCHEMA::ALTER($this, function(DRAFT $DRAFT){

                $DRAFT::DROP(true); <span class="comment">//drop current table</span>
                
            })

        }

        function tablename() : string {

            return 'users';

        }


    }
                    </pre>
                        </div> <br><br>

                        <div class="foot-note">
                            The format in the <code>up()</code> method for migration file above will create a new table <code>"users"</code> 
                            having the defined fields above when the <code>migrate up</code> is called from the cli. However, if the down migration 
                            was implemented, the table will be dropped through the <code>DBSCHEMA::ALTER()</code> method.
                        </div>

                    </div>

                    <div class="migration-schema">
                        <div class="c-orange font-em-1d5">Migration Schema</div>
                        <div class="d87 mvt-4">
                           The <code>DBSCHEMA</code> class is the only class that makes it easier to create manage tables successfully through the 
                           command line environment. Along with a <code>DRAFT</code> class, they can create, alter, modify, change or drop database 
                           tables. The <code>DBSCHEMA</code> class has only four main methods which are listed below: 
                           <br> 
                            <div class="mvt-10">
                                <div class="">
                                    The <code>DBSCHEMA::CREATE()</code> method is used to generate or create database tables
                                </div> <br>
                                <div class="">
                                    The <code>DBSCHEMA::ALTER()</code> method is used to alter or modify existing database tables
                                </div> <br>
                                <div class="">
                                    The <code>DBSCHEMA::DROP_TABLE()</code> method is the easiest way to drop a table outside the 
                                    <code>DB::ALTER()</code> scope
                                </div> <br>
                                <div class="">
                                    The <code>DBSCHEMA::DROP_FIELD()</code> method is the easiest way to drop a table's column outside the 
                                    <code>DB::ALTER()</code> scope.
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div class="migration-draft">
                        <div class="c-olive">Migration Draft</div>
                        <div class="d87 mvt-4">
                            <p class="">
                                The <code>DRAFT</code> class defines the structure and format of a table. It contains database designs and modification 
                                plans. This class uses methods to pivot how a table should be modififed or created. These methods are used to either define 
                                a table's data type or foreign constraints or used to alter a tables structure. There are lists of methods which can be applied 
                                and we shall be taking a closer look to some of these methods:
                            </p>
                            <div class="mvt-10">

                                <div class="data-type-methods">
                                    <div class="c-sea-blue">Data type methods</div>
                                    <div class="">
                                        These methods helps to define the type of a field. The can be applied either within the <code>DBSCHEMA::CREATE()</code> 
                                        or <code>DBSCHEMA::ALTER()</code> environment. This is because they can be used when generating or modifying a table's 
                                        column.
                                    </div>
                                    <code>VARCHAR()</code>,
                                    <code>CHAR()</code>,
                                    <code>ENUM()</code>,
                                    <code>JSON()</code>,
                                    <code>TEXT()</code>,
                                    <code>TEXTFIELD()</code>,
                                    <code>INT()</code>,
                                    <code>INTFIELD()</code>,
                                    <code>BOOL()</code>,
                                    <code>BIT()</code>,
                                    <code>BINARY()</code>,
                                    <code>SERIAL()</code>,
                                    <code>DATE()</code>,
                                    <code>TIME()</code>,
                                    <code>YEAR()</code>,
                                    <code>BLOB()</code>,
                                    <code>BLOBFIELD()</code>,
                                    <code>REAL()</code>,
                                    <code>DECIMAL()</code>,
                                    <code>DOUBLE()</code>,
                                    <code>FLOAT()</code>,
                                    <code>SET()</code>
                                    <code>COMMENT()</code>
                                </div> <br>

                                <div class="constraint-methods">
                                    <div class="c-sea-blue">Constraint related methods</div>
                                    <code>DEFAULT()</code>,
                                    <code>NULL()</code>,
                                    <code>NOT_NULL()</code>,
                                    <code>SIGNED()</code>,
                                    <code>UNSIGNED()</code>,
                                    <code>INDEX()</code>,
                                    <code>UNIQUE()</code>,
                                    <code>FOREIGN_KEY()</code>,
                                    <code>PRIMARY_KEY()</code>,
                                    <code>CONSTRAINT()</code>,
                                    <code>AUTO()</code> or
                                    <code>AUTO_INCREMENT()</code>,
                                    <code>CASCADE()</code>,
                                    <code>RESTRICT()</code>
                                </div> <br>

                                <div class="modifier-methods">
                                    <div class="c-sea-blue">Modifier methods</div>
                                    <div class="">
                                        These methods are only defined within the <code>DBSCHEMA::ALTER()</code> environment. 
                                        This is because their main function is to modify an already existing table. There are only three 
                                        type of these method which are <code>MODIFY()</code>, <code>CHANGE()</code> and <code>DROP()</code>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div> <br>

                    <div class="defining-database">
                              <div class="c-olive">Setting column data type</div>
                        <div class="d87">
                            <div class="mvs-10">
                                The data type methods above sets the data type of field. All methods are first supplied with the 
                                column name after which other properties are defined based on size or precision depending on the 
                                type of method called. The methods are therefore, grouped into different categories based on the 
                                argument they require. The groups are defined below:
                            </div>

                            <div class="groups">
                                <div class="">
                                    <!-- <code>ID(<span class="c-grey">int $size = 0, string $name = 'id'</span>)</code> -->
                                </div>
                                <div class="">
                                    <code>VARCHAR(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>CHAR(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>ENUM(<span class="c-grey">$name, $options, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>TEXT(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>INT(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>TEXTFIELD(<span class="c-grey">$type, $name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>INTFIELD(<span class="c-grey">$type, $name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>BIT(<span class="c-grey">$name</span>)</code>
                                </div>
                                <div class="">
                                    <code>BINARY(<span class="c-grey">$name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>BOOL(<span class="c-grey">$name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>SERIAL(<span class="c-grey">$name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>FLOAT(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>DOUBLE(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>DECIMAL(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>REAL(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>DATE(<span class="c-grey">$name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>DATETIME(<span class="c-grey">$name, $precision, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>TIMESTAMP(<span class="c-grey">$name, $precision, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>TIME(<span class="c-grey">$name, $precision, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>YEAR(<span class="c-grey">$name, $precision, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>BLOB(<span class="c-grey">$name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>BLOBFIELD(<span class="c-grey">$type, $name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>COMMENT(<span class="c-grey">$string</span>)</code>
                                </div>

                                <div class="foot-note mvs-10">
                                    Arguments are defined by the scope in which they are used or the type of field being created. 
                                    Each of these arguments are explained below:
                                </div>

                                <div class="bc-white-dd pxv-4">
                                    <code>$name</code> 
                                    <span>
                                        This is usually the first argument of any of the data type methods except in <code>INTFIELD()</code> 
                                        <code>BLOBFIELD</code> and <code>TEXTFIELD</code> method where it comes as the second argument. 
                                        It defines the name of a table's column when used within 
                                        the <code>DBSCHEMA::CREATE()</code> scope. However, within the <code>DBSCHEMA::ALTER</code> 
                                        it supports an array of old column name to new table name, where the index of the array is the 
                                        old column name while the value of that array index is the new column name.
                                    </span>
                                </div> <br>

                                <div class="bc-white-dd pxv-4">
                                    <code>$type</code> 
                                    <span>
                                        This is usually the first argument of any of the three data type methods <code>INTFIELD()</code> 
                                        <code>BLOBFIELD</code> and <code>TEXTFIELD</code>. It mostly defines the type of a relative data type. 
                                        The <code>$type</code> argument only defines the type of field based on relative options  as listed below 
                                        <div class="pxv-10">

                                            <table class="font-em-d85 c-teal">
                                                <tr>
                                                    <th class="clip-100">Field</th>
                                                    <th class="clip-150">Description</th>
                                                    <th>Options</th>
                                                </tr>
                                                <tr>
                                                    <td>INTFIELD</td>
                                                    <td>For integer columns</td>
                                                    <td>[ INT | [TINYINT/TINY] | [SMALLINT/SMALL] | [BIGINT/BIG] ]</td></tr>
                                                <tr>
                                                    <td>TEXTFIELD</td>
                                                    <td>For text columns</td>
                                                    <td>[ TEXT | [TINYTEXT/TINY] | [MEDIUMTEXT/MEDIUM] | [LONGTEXT/LONG] ]</td>
                                                </tr>
                                                <tr>
                                                    <td>BLOBFIELD</td>
                                                    <td>For text columns</td>
                                                    <td>[ BLOB | [TINYBLOB/TINY] | [SMALLBLOB/SMALL] [MEDIUMBLOB/MEDIUM] | [LONGBLOB/LONG] ]</td>
                                                </tr>
                                            </table>

                                        </div>

                                        Options such as <code>TINY</code>, <code>SMALL</code>, <code>BIG</code>, <code>MEDIUM</code> and 
                                        <code>LONG</code> are usually aliases for their respective methods.
                                        
                                    </span>
                                </div> <br>

                                <div class="bc-white-dd pxv-4">
                                    <code>$size</code> 
                                    <span>
                                        This defines the size of a table's column. Most but not all of the data type methods supports the 
                                        <code>$size</code> argument. The $size method may exist as an array, string or integer depending on the type of 
                                        table column being defined. In methods such as <code>FLOAT</code>, <code>DOUBLE</code>, <code>DECIMAL</code> 
                                        and <code>REAL</code>, the <code>$size</code> usually define both the precision and column length. In integer 
                                        related methods, the <code>$size</code> is defined as a string while in text related methods, it is defined as a string. 
                                        In decimal related methods such as <code>FLOAT</code>, <code>DECIMAL</code>, <code>REAL</code> and <code>DOUBLE</code>, 
                                        this argument is supplied as an array. 
                                    </span>
                                </div> <br>

                                <div class="bc-white-dd pxv-4">
                                    <code>$option</code> 
                                    <span>
                                        This argument is only implemented by the <code>ENUM()</code> method which is an array that contains a list of 
                                        valid options to be applied on a field.
                                    </span>
                                </div> <br>

                                <div class="bc-white-dd pxv-4">
                                    <code>$precision</code> 
                                    <span>
                                        This argument is only used in time related methods such as <code>DATE</code>, 
                                        <code>DATETIME</code>, <code>TIMESTAMP</code>, <code>TIME</code> and <code>YEAR</code>. 
                                        It defines the precision for the field that is expected to be created or modified.
                                    </span>
                                </div> <br>

                                <div class="bc-white-dd pxv-4">
                                    <code>$default</code> 
                                    <span>
                                        In methods that implements this argument, the argument sets a default value for the field or column 
                                        to be created. This can also be added by using the <code>DEFAULT()</code> constriant method.
                                    </span>
                                </div>

                                <div class="bc-white-dd pxv-4">
                                    <code>$comment</code> 
                                    <span>
                                        This argument is implemented by the <code>COMMENT()</code> method. It is used to set a comment on a particular 
                                        field.
                                    </span>
                                </div>

                            </div>
                        </div>              
                    </div> <br>

                    <div class="">
                        <div class="c-olive-dd">Setting database column constraints</div>
                        <div class="d87">
                            <div class="">
                                Constraint methods are used to apply contraints on table columns. These constraint can be applied during table 
                                creation or modification on tables or generated table columns. These methods include <code>DEFAULT()</code>, 
                                <code>NULL</code>, <code>NOT_NULL()</code>, <code>PRIMARY_KEY()</code>, <code>FOREIGN_KEY()</code> are listed and explained below:
                            </div>
                            <br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">DEFAULT CONSTRAINT</div>
                                <div class="">
                                    The method <code>DEFAULT()</code> is used to set a default value for a field. While numeric values may be supplied for  
                                    interger or float fields, strings are mostly used to define string values, constants or functions. 
                                    Generally, all strings arguments are treated as string unless it uses a defined structure for constant or functions. 
    
                                    <div class="defining-constants">
                                        <div class=""> Defining special strings </div>
                                        <div class="">
                                            Special strings are known as unquoted strings which may be a constant or function. In order to separate normal strings from 
                                            special string, the special strings must be wrapped within a parenthesis (i.e "(value)"). Any value placed within the parenthesis is 
                                        treated as a special string. In this way, setting a default <span class="c-teal">"CURRENT_TIMESTAMP"</span>  constant will be defined as 
                                            <code>DEFAULT("(CURRENT_TIMESTAMP)")</code> while systemic functions such as <span class="c-teal">"GETDATE()"</span> can be defined 
                                            as <code>"(GET_DATE())"</code>. Without setting the parenthesis, the value may be treated as a normal string.
                                        </div>    
                                    </div>
                                </div>
                            </div> <br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">NULL and NOT NULL CONSTRAINT</div>
                                <div class="">
                                    The method <code>NOT_NULL()</code> is used to set a "NOT NULL" constraint on fields while the <code>NULL()</code> 
                                    method defines that a field may accept a null value.
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">SIGNED AND UNSIGNED CONSTRAINT</div>
                                <div class="">
                                    The <code>SIGNED()</code> or <code>UNSIGNED()</code> constraints can be chained along with an <code>INT()</code> or 
                                    <code>INTFIELD()</code> method which literally defines whether the intented integer field to be created is signed or unsigned.
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">CONSTRAINT METHOD</div>
                                <div class="">
                                    The <code>CONSTRAINT()</code> method is used to define a new constraint that has an identifier name which can be used to store the 
                                    intended unique or foreign key field. It takes an argument of an index storage name. Usually, this method may come before methods like 
                                    <code>UNIQUE()</code> or <code>FOREIGN_KEY()</code> is called.
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">UNIQUE CONSTRAINT</div>
                                <div class="">
                                    A unique constraint can be set on a single field by chaining it on a any of the data type methods. In this case, no argument is 
                                    required because the current field is assumed to be the unique field. However, to set multiple fields as unique 
                                    fields, they must be called on the <code>CONSTRAINT()</code> method which takes an argument of the unique identifier name. If the 
                                    <code>UNIQUE()</code> method is chained on <code>CONSTRAINT()</code>, then multiple column names can be supplied as an array which denotes that 
                                    the array lists of supplied column names are intented to be uniquely binded.
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">PRIMARY KEY CONSTRAINT</div>
                                <div class="">
                                    In order to define a field as a primary key field, the <code>PRIMARY_KEY()</code> method is employed. 
                                    This method can take a string or an array as the names of fields intended to be set as primary key field. 
                                    When no argument is supplied, it uses the current field name as the intented primary key field.
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">AUTO (or AUTO_INCREMENT) CONSTRAINT</div>
                                <div class="">
                                    The <code>AUTO()</code> is a short alias for <code>AUTO_INCREMENT()</code> which defines the automatic increment feature on a primarily defined 
                                    integer column. 
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">FOREIGN KEY CONSTRAINT</div>
                                <div class="">
                                   This method is used to apply a foreign key constraint on two tables. In this case, the first argument 
                                   is expected to be the parent table's name while the second argument is an array which contains an 
                                   index and relative value. The index is expected to be the foreign key (or column) name in the current migration table while 
                                   the value is the local key (or column) name on the parent table
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">INDEX CONSTRAINT</div>
                                <div class="">
                                   The <code>INDEX()</code> method sets an index constraint on a table's field.
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="">
                        <div class="modifiers">Modifying Fields</div>
                        <p class="">
                            The <code>DROP()</code> method drops a database table, databse table column or database table's index. 
                            It takes one or two arguments depending on what is expected to be dropped. If the first argument is set as true, 
                            then the current database table will be dropped. However, if the first argument is string, it is assumed that the migration table's 
                            field is expected to be dropped unless a second argument is provided in which case, the first agument is assumed to be an index type 
                            (e.g UNIQUE) while second argument will be the index name that is expected to be dropped.
                        </p>
                        <p class="">
                            The <code>MODIFY()</code> and <code>CHANGE()</code> methods are both used to modify a field. The only argument they require is a closure 
                            which must return a <code>DRAFT</code> object. All modifer methods are restricted to the <code>DBSCHEMA::ALTER()</code> environment since it is the 
                            only environment that supports table modification.
                        </p>
                    </div>

                    <div class="">
                        <div class="sample-structures">
                            Sample structures
                        </div>
                        The following examples below are structures which defines the format in which a migration table can be created or dropped using the <code>DBSCHEMA</code> class. 

                        <div class="pre-area">
 <pre class="pre-code">
  &lt;?php 

  class M1673742992_file_name {

    function up() {

        <span class="c-sky-blue-dd">DBSCHEMA::CREATE('user_table' function(DRAFT $DRAFT) {</span>

            $DRAFT::VARCHAR('firstname', 50, 'Felix')->NOT_NULL();
            $DRAFT::VARCHAR('lastname', 50)->DEFAULT('Brussels')->NOT_NULL();
            $DRAFT::VARCHAR('username', 50)->UNIQUE()->NOT_NULL();
            $DRAFT::INT('number', 30)->NOT_NULL();
            $DRAFT::DECIMAL('mark', [10, 5]);
            $DRAFT::DATETIME('added_on')->DEFAULT('(CURRENT_TIMESTAMP)');

            return $DRAFT;

        <span class="c-sky-blue-dd">})</span>;

    }

    function down() {

        DBSCHEMA::ALTER('user_table', function(DRAFT $DRAFT) {

            $DRAFT::DROP(true); <span class="comment no-select">//drop current table</span>
        
        });

    }

  }
 </pre>
                        </div>

                        <div class="foot-note mvs-10">
                            In order to apply the migration file above, from the cli we have to run the migration code 
                        </div>
                        <div class="pre-area">
 <pre class="pre-code">
  php mi migrate up
 </pre>
                        </div>

                        <div class="foot-note">
                            Once this code is executed, all migration files within the <code>migrations/</code> directory 
                            will implement their <code>up()</code> method. Asssuming our code structure is like above, then 
                            from the code format, a table will be generated in the currently selected database. The connection used 
                            will depend on user default connection which must have been set in the <code>icore/dbconfig.php</code> 
                            file. Both the firstname and lastname will implement a default value of "Felix" and "Brussels" respectively 
                            with the default maximum length set at <span class="c-teal">50</span> while the "username" field will be a unique field. The "number" column will be an integer 
                            column while a decimal column "mark" will have a precision of "10, 5". The "DATETIME" method will however create 
                            an "added_on" field with a default value of <code>CURRENT_TIMESTAMP</code>
                        </div> <br>

                        <div class="foot-note">
                            In order to migrate down, from the cli, we can simple run the command: 
                        </div>

                        <div class="pre-area mvt-10">
 <pre class="pre-code">
  php mi migrate down
 </pre>
                        </div>

                        <div class="foot-note mvs-10">
                            The command above will step down migration files starting from the last excuted migration file and ending in the first migration file by calling the <code>down()</code> 
                            method of each migration file. Whenever we have multiple files, we can also step down our migration files in a number of times, for example 4 times. In order to do this 
                            we simply add the number of times we want to step down our migration file to the step down migration code above. This means that a code like: 
                        </div>

                        <div class="pre-area mvt-10">
 <pre class="pre-code">
  php mi migrate down 4
 </pre>
                        </div>

                        <div class="foot-note mvs-10">
                            The code above will only step down 4 recently applied migration files. This stepping down system is only applied for a down migration. 
                            Other examples that explains more on table creation and modification can be accessed from here.
                        </div>

                    </div>

                </div>
                
            </div>
        </div>
    </section>
</div>

@lay('build.co.coords:footer')

@template;