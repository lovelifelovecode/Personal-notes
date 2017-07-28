<?php if ($expression == true): ?>
  This will show if the expression is true.
<?php else: ?>
  Otherwise this will show.
<?php endif; ?>
上例中 PHP 将跳过条件语句未达成的段落，即使该段落位于 PHP 开始和结束标记之外。由于 PHP 解释器会在条件未达成时直接跳过该段条件语句块，因此 PHP 会根据条件来忽略之。要输出大段文本时，跳出 PHP 解析模式通常比将文本通过 echo 或 print 输出更有效率。 


如果想查看某个表达式的值和类型，用 var_dump() 函数。 
如果只是想得到一个易读懂的类型的表达方式用于调试，用 gettype() 函数。要查看某个类型，不要用 gettype()，而用 is_type 函数。

当转换为 boolean 时，以下值被认为是 FALSE： 
布尔值 FALSE 本身 
整型值 0（零） 
浮点型值 0.0（零） 
空字符串，以及字符串 "0" 
不包括任何元素的数组 
不包括任何成员变量的对象（仅 PHP 4.0 适用） 
特殊类型 NULL（包括尚未赋值的变量） 
从空标记生成的 SimpleXML 对象 
所有其它值都被认为是 TRUE（包括任何资源）。 
Warning 
-1 和其它非零值（不论正负）一样，被认为是 TRUE！

要使用八进制表达，数字前必须加上 0（零）。要使用十六进制表达，数字前必须加上 0x。要使用二进制表达，数字前必须加上 0b。


整数溢出
如果给定的一个数超出了 integer 的范围，将会被解释为 float。同样如果执行的运算结果超出了 integer 范围，也会返回 float。 
Example #3 32 位系统下的整数溢出 
<?php
  $large_number = 2147483647;
  var_dump($large_number);                     // int(2147483647)
  $large_number = 2147483648;
  var_dump($large_number);                     // float(2147483648)
  $million = 1000000;
  $large_number =  50000 * $million;
  var_dump($large_number);                     // float(50000000000)
?> 


Warning 
决不要将未知的分数强制转换为 integer，这样有时会导致不可预料的结果。 
<?php
  echo (int) ( (0.1+0.7) * 10 ); // 显示 7!
?> 


如果文件内容是纯 PHP 代码，最好在文件末尾删除 PHP 结束标记。这可以避免在 PHP 结束标记之后万一意外加入了空格或者换行符，会导致 PHP 开始输出这些空白，而脚本中此时并无输出的意图。 


以十进制能够精确表示的有理数如 0.1 或 0.7，无论有多少尾数都不能被内部所使用的二进制精确表示，因此不能在不丢失一点点精度的情况下转换为二进制的格式。这就会造成混乱的结果：例如，floor((0.1+0.7)*10) 通常会返回 7 而不是预期中的 8，因为该结果内部的表示其实是类似 7.9999999999999991118...。 
所以永远不要相信浮点数结果精确到了最后一位，也永远不要比较两个浮点数是否相等。如果确实需要更高的精度，应该使用任意精度数学函数或者 gmp 函数


比较浮点数
如上述警告信息所言，由于内部表达方式的原因，比较两个浮点数是否相等是有问题的。不过还是有迂回的方法来比较浮点数值的。
要测试浮点数是否相等，要使用一个仅比该数值大一丁点的最小误差值。该值也被称为机器极小值（epsilon）或最小单元取整数，是计算中所能接受的最小的差别值。
$a 和 $b 在小数点后五位精度内都是相等的。
<?php
  $a = 1.23456789;
  $b = 1.23456780;
  $epsilon = 0.00001;

  if(abs($a-$b) < $epsilon) {
      echo "true";
  }
?>

字符串的Heredoc 结构
以<<<End开始标记开始，以End结束标记结束，结束标记必须顶头写，不能有缩进和空格，且在结束标记末尾要有分号 。开始标记和开始标记相同，比如常用大写的EOT、EOD、EOF来表示，但是不只限于那几个，只要保证开始标记和结束标记不在正文中出现即可。 

.heredoc常用在输出包含大量HTML语法d文档的时候。比如：函数outputhtml()要输出HTML的主页。可以有两种写法。很明显第二种写法比较简单和易于阅读。
复制代码 代码如下:
<?php
function outputhtml(){
  echo "<html>";
  echo "<head><title>主页</title></head>";
  echo "<body>主页内容</body>";
  echo "</html>";
}

function outputhtml(){
  echo <<<EOT
     <html>
     <head><title>主页</title></head>
     <body>主页内容</body>
     </html>
EOT;
}
  outputhtml();
?>


Heredoc 结构就象是没有使用双引号的双引号字符串，这就是说在 heredoc 结构中单引号不用被转义，但是上文中列出的转义序列还可以使用。变量将被替换，但在 heredoc 结构中含有复杂的变量时要格外小心。
Example #2 Heredoc 结构的字符串示例 
<?php
  $str = <<<EOD
  Example of string
  spanning multiple lines
  using heredoc syntax.
EOD;

  /**
   * 含有变量的更复杂示例
   */
  class foo {
    var $foo;
    var $bar;

    function foo() {
      $this -> foo = 'Foo17';
      $this -> bar = array('Bar1', 'Bar2', 'Bar3');
    } 
  } 

  $foo = new foo();
  $name = 'xiaojing';

  echo <<<EOT
  My name is "$name". I am printing some $foo->foo.
  Now, I am printing some {$foo->bar[1]}.
  This should print a capital 'A': \x41
EOT;
?>

 Heredocs 结构不能用来初始化类的属性。自 PHP 5.3 起，此限制仅对 heredoc 包含变量时有效。
Example #1 非法的示例
<?php
  class foo {
      public $bar = <<<EOT
bar
EOT;
}
?>


也可以把 Heredoc 结构用在函数参数中来传递数据：
Example #3 Heredoc 结构在参数中的示例
<?php
  var_dump(array(<<<EOD
  foobar!
EOD
  ));
?>


在 PHP 5.3.0 以后，也可以用 Heredoc 结构来初始化静态变量和类的属性和常量：
Example #4 使用 Heredoc 结构来初始化静态值
<?php 
  // 静态变量
  function foo() {
    static $bar = <<<LABEL
  Nothing in here...
LABEL;
  } 
  // 类的常量、属性
  class foo {
    const BAR = <<<FOOBAR
  Constant example
FOOBAR;

    public $baz = <<<FOOBAR
  Property example
FOOBAR;
  } 
?>


自 PHP 5.3.0 起还可以在 Heredoc 结构中用双引号来声明标识符：
Example #5 在 heredoc 结构中使用双引号
<?php
  echo <<<"FOOBAR"
  Hello World!
FOOBAR;
?>


Nowdoc 结构 ¶

就象 heredoc 结构类似于双引号字符串，Nowdoc 结构是类似于单引号字符串的。Nowdoc 结构很象 heredoc 结构，但是 nowdoc 中不进行解析操作。这种结构很适合用于嵌入 PHP 代码或其它大段文本而无需对其中的特殊字符进行转义。与 SGML 的 <![CDATA[ ]]> 结构是用来声明大段的不用解析的文本类似，nowdoc 结构也有相同的特征。

一个 nowdoc 结构也用和 heredocs 结构一样的标记 <<<， 但是跟在后面的标识符要用单引号括起来，即 <<<'EOT'。Heredoc 结构的所有规则也同样适用于 nowdoc 结构，尤其是结束标识符的规则。  

Example #6 Nowdoc 结构字符串示例
<?php
  $str = <<<'EOD'
  Example of string
  spanning multiple lines
  using nowdoc syntax.
EOD;

  /* 含有变量的更复杂的示例 */
  class foo
  {
      public $foo;
      public $bar;

      function foo()
      {
          $this->foo = 'Foo';
          $this->bar = array('Bar1', 'Bar2', 'Bar3');
      }
  }

  $foo = new foo();
  $name = 'MyName';

  echo <<<'EOT'
  My name is "$name". I am printing some $foo->foo.
  Now, I am printing some {$foo->bar[1]}.
  This should not print a capital 'A': \x41
EOT;
?>



Note:不象 heredoc 结构，nowdoc 结构可以用在任意的静态数据环境中，最典型的示例是用来初始化类的属性或常量：
Example #7 静态数据的示例
<?php
  class foo {
      public $bar = <<<'EOT'
bar
EOT;
}
?>


变量解析 ¶
当字符串用双引号或 heredoc 结构定义时，其中的变量将会被解析。 
Example #8 简单语法示例
<?php
  $juices = array("apple", "orange", "koolaid1" => "purple");

  echo "He drank some $juices[0] juice."."<br />";
  echo "He drank some $juices[1] juice."."<br />";
  echo "He drank some juice made of $juices[0]s."."<br />"; // Won't work
  echo "He drank some $juices[koolaid1] juice."."<br />";

  class people {
      public $john = "John Smith";
      public $jane = "Jane Smith";
      public $robert = "Robert Paulsen";
      
      public $smith = "Smith";
  }

  $people = new people();

  echo "$people->john drank some $juices[0] juice."."<br />";
  echo "$people->john then said hello to $people->jane."."<br />";
  echo "$people->john's wife greeted $people->robert."."<br />";
  echo "$people->robert greeted the two $people->smith."; // Won't work
?>


变量解析 复杂（花括号）语法
复杂语法不是因为其语法复杂而得名，而是因为它可以使用复杂的表达式。
任何具有 string 表达的标量变量，数组单元或对象属性都可使用此语法。只需简单地像在 string 以外的地方那样写出表达式，然后用花括号 { 和 } 把它括起来即可。由于 { 无法被转义，只有 $ 紧挨着 { 时才会被识别。可以用 {\$ 来表达 {$。下面的示例可以更好的解释： 
<?php
  // 显示所有错误
  error_reporting(E_ALL);

  $great = 'fantastic';

  // 无效，输出: This is { fantastic}
  echo "This is { $great}";

  // 有效，输出： This is fantastic
  echo "This is {$great}";
  echo "This is ${great}";

  // 有效
  echo "This square is {$square->width}00 centimeters broad."; 

  // 有效，只有通过花括号语法才能正确解析带引号的键名
  echo "This works: {$arr['key']}";

  // 有效
  echo "This works: {$arr[4][3]}";

  // 这是错误的表达式，因为就象 $foo[bar] 的格式在字符串以外也是错的一样。
  // 换句话说，只有在 PHP 能找到常量 foo 的前提下才会正常工作；这里会产生一个
  // E_NOTICE (undefined constant) 级别的错误。
  echo "This is wrong: {$arr[foo][3]}"; 

  // 有效，当在字符串中使用多重数组时，一定要用括号将它括起来
  echo "This works: {$arr['foo'][3]}";

  // 有效
  echo "This works: " . $arr['foo'][3];

  echo "This works too: {$obj->values[3]->name}";

  echo "This is the value of the var named $name: {${$name}}";

  echo "This is the value of the var named by the return value of getName(): {${getName()}}";

  echo "This is the value of the var named by the return value of \$object->getName(): {${$object->getName()}}";

  // 无效，输出： This is the return value of getName(): {getName()}
  echo "This is the return value of getName(): {getName()}";
?>


也可以在字符串中用此语法通过变量来调用类的属性。
<?php
  class foo {
      var $bar = 'I am bar.';
  }

  $foo = new foo();
  $bar = 'bar';
  $baz = array('foo', 'bar', 'baz', 'quux');
  echo "{$foo->$bar}\n";
  echo "{$foo->$baz[1]}\n";
?>


Note:函数、方法、静态类变量和类常量只有在 PHP 5 以后才可在 {$} 中使用。然而，只有在该字符串被定义的命名空间中才可以将其值作为变量名来访问。只单一使用花括号 ({}) 无法处理从函数或方法的返回值或者类常量以及类静态变量的值。 
<?php
  // 显示所有错误
  error_reporting(E_ALL);

  class beers {
      const softdrink = 'rootbeer';
      public static $ale = 'ipa';
  }

  $rootbeer = 'A & W';
  $ipa = 'Alexander Keith\'s';   //'

  // 有效，输出： I'd like an A & W
  echo "I'd like an {${beers::softdrink}}\n";

  // 也有效，输出： I'd like an Alexander Keith's
  echo "I'd like an {${beers::$ale}}\n";
?>


存取和修改字符串中的字符 ¶
string 中的字符可以通过一个从 0 开始的下标，用类似 array 结构中的方括号包含对应的数字来访问和修改，比如 $str[42]。可以把 string 当成字符组成的 array。函数 substr() 和 substr_replace() 可用于操作多于一个字符的情况。

Note: string 也可用花括号访问，比如 $str{42}。
Warning:PHP 的字符串在内部是字节组成的数组。因此用花括号访问或修改字符串对多字节字符集很不安全。仅应对单字节编码例如 ISO-8859-1 的字符串进行此类操作。


Example #9 一些字符串示例
<?php
  // 取得字符串的第一个字符
  $str = 'This is a test.';
  $first = $str[0];

  // 取得字符串的第三个字符
  $third = $str[2];

  // 取得字符串的最后一个字符
  $str = 'This is still a test.';
  $last = $str[strlen($str)-1]; 

  // 修改字符串的最后一个字符
  $str = 'Look at the sea';
  $str[strlen($str)-1] = 'e';
?>

ps2:(注意！！！！！！)
<?php
    $str='xiao';
    $str[2]='jing';
    var_dump($str);//输出xijo
?>

自 PHP 5.4 起字符串下标必须为整数或可转换为整数的字符串，否则会发出警告。之前例如 "foo" 的下标会无声地转换成 0。
Example #10 PHP 5.3 和 PHP 5.4 的区别
<?php
  $str = 'abc';

  var_dump($str['1']);
  var_dump(isset($str['1']));

  var_dump($str['1.0']);
  var_dump(isset($str['1.0']));

  var_dump($str['x']);
  var_dump(isset($str['x']));

  var_dump($str['1x']);
  var_dump(isset($str['1x']));
?>


一个布尔值 boolean 的 TRUE 被转换成 string 的 "1"。Boolean 的 FALSE 被转换成 ""（空字符串）。这种转换可以在 boolean 和 string 之间相互进行。

数组 array 总是转换成字符串 "Array"，因此，echo 和 print 无法显示出该数组的内容。要显示某个单元，可以用 echo $arr['foo'] 这种结构。

在 PHP 4 中对象 object 总是被转换成字符串 "Object"，如果为了调试原因需要打印出对象的值，请继续阅读下文。为了得到对象的类的名称，可以用 get_class() 函数。自 PHP 5 起，适当时可以用 __toString 方法。

资源 resource 总会被转变成 "Resource id #1" 这种结构的字符串，其中的 1 是 PHP 在运行时分配给该 resource 的唯一值。不要依赖此结构，可能会有变更。要得到一个 resource 的类型，可以用函数 get_resource_type()。 

NULL 总是被转变成空字符串。

如上面所说的，直接把 array，object 或 resource 转换成 string 不会得到除了其类型之外的任何有用信息。可以使用函数 print_r() 和 var_dump() 列出这些类型的内容。

大部分的 PHP 值可以转变成 string 来永久保存，这被称作串行化，可以用函数 serialize() 来实现。如果 PHP 引擎设定支持 WDDX，PHP 值也可被串行化为格式良好的 XML 文本。 


字符串转换为数值 ¶
当一个字符串被当作一个数值来取值，其结果和类型如下：
如果该字符串没有包含 '.'，'e' 或 'E' 并且其数字值在整型的范围之内（由 PHP_INT_MAX 所定义），该字符串将被当成 integer 来取值。其它所有情况下都被作为 float 来取值。

该字符串的开始部分决定了它的值。如果该字符串以合法的数值开始，则使用该数值。否则其值为 0（零）。合法数值由可选的正负号，后面跟着一个或多个数字（可能有小数点），再跟着可选的指数部分。指数部分由 'e' 或 'E' 后面跟着一个或多个数字构成。
<?php
  $foo = 1 + "10.5";                // $foo is float (11.5)
  $foo = 1 + "-1.3e3";              // $foo is float (-1299)
  $foo = 1 + "bob-1.3e3";           // $foo is integer (1)
  $foo = 1 + "bob3";                // $foo is integer (1)
  $foo = 1 + "10 Small Pigs";       // $foo is integer (11)
  $foo = 4 + "10.2 Little Piggies"; // $foo is float (14.2)
  $foo = "10.0 pigs " + 1;          // $foo is float (11)
  $foo = "10.0 pigs " + 1.0;        // $foo is float (11)     
?>


静态变量可以按照上面的例子声明。如果在声明中用表达式的结果对其赋值会导致解析错误。
Example #7 声明静态变量
<?php
  function foo(){
      static $int = 0;          // correct
      static $int = 1+2;        // wrong  (as it is an expression)
      static $int = sqrt(121);  // wrong  (as it is an expression too)

      $int++;
      echo $int;
  }
?>



htmlspecialchars() 函数把特殊字符转换为 HTML 实体.通过使用 htmlspecialchars() 函数能够避免 $_SERVER["PHP_SELF"] 被利用。
表单代码是这样的：
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

在用户提交该表单时，我们还要做两件事：

    1（通过 PHP trim() 函数）去除用户输入数据中不必要的字符（多余的空格、制表符、换行）
    2（通过 PHP stripslashes() 函数）删除用户输入数据中的反斜杠（\）


foreach只能遍历一二维数组了，如果是三维数组我们需要进行递归操作了。

ceil — 进一法取整 
float ceil ( float $value ) 


filesize — 取得文件大小 
int filesize ( string $filename )
<?php
  // 输出类似：somefile.txt: 1024 bytes
  $filename = 'somefile.txt';
  echo $filename . ': ' . filesize($filename) . ' bytes';
?> 

resource fopen ( string $filename , string $mode [, bool $use_include_path = false [, resource $context ]] ) 
mode 参数指定了所要求到该流的访问类型。可以是以下： 
r 	打开文件为只读。文件指针在文件的开头开始。
w 	打开文件为只写。删除文件的内容或创建一个新的文件，如果它不存在。文件指针在文件的开头开始。
a 	打开文件为只写。文件中的现有数据会被保留。文件指针在文件结尾开始。创建新的文件，如果文件不存在。
x 	创建新文件为只写。返回 FALSE 和错误，如果文件已存在。
r+ 	打开文件为读/写、文件指针在文件开头开始。
w+ 	打开文件为读/写。删除文件内容或创建新文件，如果它不存在。文件指针在文件开头开始。
a+ 	打开文件为读/写。文件中已有的数据会被保留。文件指针在文件结尾开始。创建新文件，如果它不存在。
x+ 	创建新文件为读/写。返回 FALSE 和错误，如果文件已存在 


如果您用 fopen() 打开并不存在的文件，此函数会创建文件，假定文件被打开为写入（w）或增加（a）。


<form> 标签的 enctype 属性规定了在提交表单时要使用哪种内容类型。在表单需要二进制数据时，比如文件内容，请使用 "multipart/form-data"。
<form action="upload_file.php" method="post" enctype="multipart/form-data">


move_uploaded_file — 将上传的文件移动到新位置 
bool move_uploaded_file ( string $filename , string $destination ) 


对于 IE 识别 jpg 文件的类型必须是 pjpeg，对于 FireFox，必须是 jpeg。


file_exists — 检查文件或目录是否存在 
bool file_exists ( string $filename ) 

quotemeta()在预定义字符前添加反斜杠：
<?php
  $str = "Hello world. (can you hear me?)";
  echo quotemeta($str);
?>


ord() 函数返回字符串的首个字符的 ASCII 值。
语法：ord(string);
<?php
  echo ord("S")."<br>";
  echo ord("Shanghai")."<br>";
?>


chr() 函数从指定的 ASCII 值返回字符。
语法:chr(ascii)
<?php
  echo chr(61) . "<br>"; // 十进制
  echo chr(061) . "<br>"; // 八进制值
  echo chr(0x61) . "<br>"; // 十六进制值
?>


rand() 函数返回随机整数。
语法:rand(min,max)


ucfirst() 函数把字符串中的首字符转换为大写。
语法:ucfirst(string) 

strtoupper() 函数把字符串转换为大写。
语法:strtoupper(string)

strtolower() 函数把字符串转换为小写。
语法:strtolower(string)


array_key_exists() 函数检查某个数组中是否存在指定的键名，如果键名存在则返回 true，如果键名不存在则返回 false。
语法:array_key_exists(key,array)

current() 函数返回数组中的当前元素的值。
current(array)

array_rand() 函数返回数组中的随机键名，或者如果您规定函数返回不只一个键名，则返回包含随机键名的数组。
array_rand(array,number)

array_merge() 函数把一个或多个数组合并为一个数组。
语法:array_merge(array1,array2,array3...)

array_chunk() 函数把数组分割为新的数组块。
语法:array_chunk(array,size,preserve_key);

array_push() 函数向第一个参数的数组尾部添加一个或多个元素（入栈），然后返回新数组的长度。
该函数等于多次调用 $array[] = $value。
语法:array_push(array,value1,value2...)


array_splice() 函数从数组中移除选定的元素，并用新元素取代它。该函数也将返回包含被移除元素的数组。
语法:array_splice(array,start,length,array)


array_pop() 函数删除数组中的最后一个元素。
语法:array_pop(array)

array_unique() 函数移除数组中的重复的值，并返回结果数组。
当几个数组元素的值相等时，只保留第一个元素，其他的元素被删除。
返回的数组中键名不变。
语法:array_unique(array)

shuffle() 函数把数组中的元素按随机顺序重新排列。
语法:shuffle(array)

similar_text() 函数计算两个字符串的相似度。
语法:similar_text(string1,string2,percent)


stristr() 函数搜索字符串在另一字符串中的第一次出现。
语法:stristr(string,search,before_search)

strrev() 函数反转字符串。
语法:strrev(string)

preg_replace — 执行一个正则表达式的搜索和替换
mixed preg_replace ( mixed $pattern , mixed $replacement , mixed $subject [, int $limit = -1 [, int &$count ]] )
搜索subject中匹配pattern的部分， 以replacement进行替换。

检查浏览页面的访问者在用什么浏览器
<?php 
  echo $_SERVER['HTTP_USER_AGENT']; 
?>

 round() 函数可以进行四舍五入

 当从浮点数转换成整数时，将向下取整。 
 e.g (int)3.7
 如果浮点数超出了整数范围（32 位平台下通常为 +/- 2.15e+9 = 2^31，64 位平台下，除了 Windows，通常为 +/- 9.22e+18 = 2^63），则结果为未定义，因为没有足够的精度给出一个确切的整数结果。在此情况下没有警告，甚至没有任何通知！ 


Array 数组 ¶
PHP 中的数组实际上是一个有序映射。映射是一种把 values 关联到 keys 的类型。此类型在很多方面做了优化，因此可以把它当成真正的数组，或列表（向量），散列表（是映射的一种实现），字典，集合，栈，队列以及更多可能性。由于数组元素的值也可以是另一个数组，树形结构和多维数组也是允许的.

 数组中的key 会有如下的强制转换：
    包含有合法整型值的字符串会被转换为整型。例如键名 "8" 实际会被储存为 8。但是 "08" 则不会强制转换，因为其不是一个合法的十进制数值。
    浮点数也会被转换为整型，意味着其小数部分会被舍去。例如键名 8.7 实际会被储存为 8。
    布尔值也会被转换成整型。即键名 true 实际会被储存为 1 而键名 false 会被储存为 0。
    Null 会被转换为空字符串，即键名 null 实际会被储存为 ""。
    数组和对象不能被用为键名。坚持这么做会导致警告：Illegal offset type。


自 5.4 起可以使用短数组定义语法，用 [] 替代 array()。
Example #1 一个简单数组
<?php
  header("content-type:text/html; charset=utf-8");
  $array = array(
      "foo" => "bar",
      "bar" => "foo",
  );

  // 自 PHP 5.4 起
  $array = [
      "foo" => "bar",
      "bar" => "foo",
  ];
?>


如果在数组定义中多个单元都使用了同一个键名，则只使用了最后一个，之前的都被覆盖了。
Example #2 类型强制与覆盖示例
<?php
  $array = array(
      1    => "a",
      "1"  => "b",
      1.5  => "c",
      true => "d",
  );
  var_dump($array);
?>

以上例程会输出：
array(1) {
  [1]=>
  string(1) "d"
}
上例中所有的键名都被强制转换为 1，则每一个新单元都会覆盖前一个的值，最后剩下的只有一个 "d"。

如果对给出的值没有指定键名，则取当前最大的整数索引值，而新的键名将是该值加一。如果指定的键名已经有了值，则该值会被覆盖。 

key 为可选项。如果未指定，PHP 将自动使用之前用过的最大 integer 键名加上 1 作为新的键名。

<?php
  $array = array(
           "a",
           "b",
      6 => "c",
           "d",
  );
  var_dump($array);
?>

以上例程会输出：

array(4) {
  [0]=>
  string(1) "a"
  [1]=>
  string(1) "b"
  [6]=>
  string(1) "c"
  [7]=>
  string(1) "d"
}


自 PHP 5.5 起可以直接对一个数组原型进行数组解引用。
Example #7 数组解引用
<?php
  function getArray() {
      return array(1, 2, 3);
  }

  // on PHP 5.4
  $secondElement = getArray()[1];

  // previously
  $tmp = getArray();
  $secondElement = $tmp[1];

  // or
  list(, $secondElement) = getArray();
?>


这是通过在方括号内指定键名来给数组赋值实现的。也可以省略键名，在这种情况下给变量名加上一对空的方括号（[]）。
$arr[key] = value;
$arr[] = value;

注：$arr[]=value,会给数组追加一个元素


要修改某个值，通过其键名给该单元赋一个新值。要删除某键值对，对其调用 unset() 函数。
<?php
  $arr = array(5 => 1, 12 => 2);

  $arr[] = 56;    // This is the same as $arr[13] = 56;
                  // at this point of the script

  $arr["x"] = 42; // This adds a new element to
                  // the array with key "x"
                  
  unset($arr[5]); // This removes the element from the array

  unset($arr);    // This deletes the whole array
?>

Note:如上所述，如果给出方括号但没有指定键名，则取当前最大整数索引值，新的键名将是该值加上 1（但是最小为 0）。如果当前还没有整数索引，则键名将为 0。 
注意这里所使用的最大整数键名不一定当前就在数组中。它只要在上次数组重新生成索引后曾经存在过就行了。以下面的例子来说明： 
<?php
  // 创建一个简单的数组
  $array = array(1, 2, 3, 4, 5);
  print_r($array);

  // 现在删除其中的所有元素，但保持数组本身不变:
  foreach ($array as $i => $value) {
      unset($array[$i]);
  }
  print_r($array);

  // 添加一个单元（注意新的键名是 5，而不是你可能以为的 0）
  $array[] = 6;
  print_r($array);

  // 重新索引：
  $array = array_values($array);
  $array[] = 7;
  print_r($array);
?>


Note:unset() 函数允许删除数组中的某个键。但要注意数组将不会重建索引。如果需要删除后重建索引，可以用 array_values() 函数。
<?php
  $a = array(1 => 'one', 2 => 'two', 3 => 'three');
  unset($a[2]);
  /* will produce an array that would have been defined as
     $a = array(1 => 'one', 3 => 'three');
     and NOT
     $a = array(1 => 'one', 2 =>'three');
  */

  $b = array_values($a);
  // Now $b is array(0 => 'one', 1 =>'three')
?>


为什么 $foo[bar] 错了？ ¶
应该始终在用字符串表示的数组索引上加上引号。例如用 $foo['bar'] 而不是 $foo[bar]。但是为什么呢？可能在老的脚本中见过如下语法：
<?php
  $foo[bar] = 'enemy';
  echo $foo[bar];
  // etc
?>
这样是错的，但可以正常运行。那么为什么错了呢？原因是此代码中有一个未定义的常量（bar）而不是字符串（'bar'－注意引号），而 PHP 可能会在以后定义此常量，不幸的是你的代码中有同样的名字。它能运行，是因为 PHP 自动将裸字符串（没有引号的字符串且不对应于任何已知符号）转换成一个其值为该裸字符串的正常字符串。例如，如果没有常量定义为 bar，PHP 将把它替代为 'bar' 并使用之。 


转换为数组 ¶

对于任意 integer，float，string，boolean 和 resource 类型，如果将一个值转换为数组，将得到一个仅有一个元素的数组，其下标为 0，该元素即为此标量的值。换句话说，(array)$scalarValue 与 array($scalarValue) 完全一样。

如果一个 object 类型转换为 array，则结果为一个数组，其单元为该对象的属性。键名将为成员变量名，不过有几点例外：整数属性不可访问；私有变量前会加上类名作前缀；保护变量前会加上一个 '*' 做前缀。这些前缀的前后都各有一个 NULL 字符。这会导致一些不可预知的行为： 
<?php
  class A {
      private $A; // This will become '\0A\0A'
  }

  class B extends A {
      private $A; // This will become '\0B\0A'
      public $AA; // This will become 'AA'
  }

  var_dump((array) new B());
?>

将 NULL 转换为 array 会得到一个空的数组。


Example #10 在循环中改变单元
<?php
  // PHP 5
  foreach ($colors as &$color) {
      $color = strtoupper($color);
  }
  unset($color); /* ensure that following writes to
  $color will not modify the last array element */

  // Workaround for older versions
  foreach ($colors as $key => $color) {
      $colors[$key] = strtoupper($color);
  }

  print_r($colors);
?>


Example #12 填充数组

<?php
  // fill an array with all items from a directory
  $handle = opendir('.');
  while (false !== ($file = readdir($handle))) {
      $files[] = $file;
  }
  closedir($handle); 
?> 


 可以将变量放置在双引号中的方式来代替将变量转换成字符串：
<?php
  $foo = 10;            // $foo 是一个整数
  $str = "$foo";        // $str 是一个字符串
  $fst = (string) $foo; // $fst 也是一个字符串

  // 输出 "they are the same"
  if ($fst === $str) {
      echo "they are the same";
  }
?>


虽然在 PHP 中并不需要初始化变量，但对变量进行初始化是个好习惯。未初始化的变量具有其类型的默认值 - 布尔类型的变量默认值是 FALSE，整形和浮点型变量默认值是零，字符串型变量（例如用于 echo 中）默认值是空字符串以及数组变量的默认值是空数组。

可变变量
	$a='king';
	$$a='good';
	echo $king; //out put 'good'

要将可变变量用于数组，必须解决一个模棱两可的问题。这就是当写下 $$a[1] 时，解析器需要知道是想要 $a[1] 作为一个变量呢，还是想要 $$a 作为一个变量并取出该变量中索引为 [1] 的值。解决此问题的语法是，对第一种情况用 ${$a[1]}，对第二种情况用 ${$a}[1]。 


Example #1 可变属性示例
<?php
  class foo {
      var $bar = 'I am bar.';
      var $arr = array('I am A.', 'I am B.', 'I am C.');
      var $r   = 'I am r.';
  }

  $foo = new foo();
  $bar = 'bar';
  $baz = array('foo', 'bar', 'baz', 'quux');
  echo $foo->$bar . "\n";
  echo $foo->$baz[1] . "\n";

  $start = 'b';
  $end   = 'ar';
  echo $foo->{$start . $end} . "\n";

  $arr = 'arr';
  echo $foo->$arr[1] . "\n";
  echo $foo->{$arr}[1] . "\n";
?>


错误控制运算符 ¶
PHP 支持一个错误控制运算符：@。当将其放置在一个 PHP 表达式之前，该表达式可能产生的任何错误信息都被忽略掉。
<?php
  /* Intentional file error */
  $my_file = @file ('non_existent_file') or
      die ("Failed opening file: error was '$php_errormsg'");

  // this works for any expression, not just functions:
  $value = @$cache[$key];
  // will not issue a notice if the index $key doesn't exist.
?>


执行运算符 ¶
PHP 支持一个执行运算符：反引号（``）。注意这不是单引号！PHP 将尝试将反引号中的内容作为 shell 命令来执行，并将其输出信息返回（即，可以赋给一个变量而不是简单地丢弃到标准输出）。使用反引号运算符“`”的效果与函数 shell_exec() 相同。
<?php
  $output = `ls -al`;
  echo "<pre>$output</pre>";
?>

Note:反引号运算符在激活了安全模式或者关闭了 shell_exec() 时是无效的。
Note:与其它某些语言不同，反引号不能在双引号字符串中使用。 





使用关键字 const 定义常量
和使用 define() 来定义常量相反的是，使用 const 关键字定义常量必须处于最顶端的作用区域，因为用此方法是在编译时定义的。这就意味着不能在函数内，循环内以及 if 语句之内用 const 来定义常量。 
<?php
  // 以下代码在 PHP 5.3.0 后可以正常工作
  const CONSTANT = 'Hello World';

  echo CONSTANT;
?>


几个 PHP 的“魔术常量”
__LINE__ 	文件中的当前行号。
__FILE__ 	文件的完整路径和文件名。
__DIR__ 	文件所在的目录。。除非是根目录，否则目录中名不包括末尾的斜杠。（PHP 5.3.0中新增） =
__FUNCTION__ 	函数名称（PHP 4.3.0 新加）。
__CLASS__ 	类的名称（PHP 4.3.0 新加）。
__TRAIT__ 	Trait 的名字（PHP 5.4.0 新加）。
__METHOD__ 	类的方法名（PHP 5.0.0 新加）。
__NAMESPACE__ 	当前命名空间的名称（区分大小写）。此常量是在编译时定义的（PHP 5.3.0 新增）。 


为 $a 的当前值加 3，可以这样写：“$a += 3”。这里的意思是“取变量 $a 的值，加 3，得到的结果再次分配给变量 $a”。除了更简略和清楚外，也可以更快的运行。


三元条件运算符：$first ? $second : $third


 取模运算符 % 的结果和被除数的符号（正负号）相同。即 $a % $b 的结果和 $a 的符号相同。例如：
<?php
  echo (5 % 3)."\n";           // prints 2
  echo (5 % -3)."\n";          // prints 2
  echo (-5 % 3)."\n";          // prints -2
  echo (-5 % -3)."\n";         // prints -2
?>


 PHP 支持引用赋值，使用“$var = &$othervar;”语法。引用赋值意味着两个变量指向了同一个数据，没有拷贝任何东西。
Example #1 引用赋值
<?php
  $a = 3;
  $b = &$a; // $b 是 $a 的引用

  如果比较一个数字和字符串或者比较涉及到数字内容的字符串，则字符串会被转换为数值并且比较按照数值来进行。此规则也适用于 switch 语句

  <?php
  var_dump(0 == "a"); // 0 == 0 -> true
  var_dump("1" == "01"); // 1 == 1 -> true
  var_dump("10" == "1e1"); // 10 == 10 -> true
  var_dump(100 == "1e2"); // 100 == 100 -> true

  switch ("a") {
  case 0:
      echo "0";
      break;
  case "a": // never reached because "a" is already matched with 0
      echo "a";
      break;
  }
?>


PHP 支持一个错误控制运算符：@。当将其放置在一个 PHP 表达式之前，该表达式可能产生的任何错误信息都被忽略掉。 


 “与”和“或”有两种不同形式运算符的原因是它们运算的优先级不同（见运算符优先级）。
Example #1 逻辑运算符示例
<?php
  // --------------------
  // foo() 根本没机会被调用，被运算符“短路”了

  $a = (false && foo());
  $b = (true  || foo());
  $c = (false and foo());
  $d = (true  or  foo());

  // --------------------
  // "||" 比 "or" 的优先级高

  // 表达式 (false || true) 的结果被赋给 $e
  // 等同于：($e = (false || true))
  $e = false || true;

  // 常量 false 被赋给 $f，true 被忽略
  // 等同于：(($f = false) or true)
  $f = false or true;

  var_dump($e, $f);

  // --------------------
  // "&&" 比 "and" 的优先级高

  // 表达式 (true && false) 的结果被赋给 $g
  // 等同于：($g = (true && false))
  $g = true && false;

  // 常量 true 被赋给 $h，false 被忽略
  // 等同于：(($h = true) and false)
  $h = true and false;

  var_dump($g, $h);
?>

以上例程的输出类似于：
bool(true)
bool(false)
bool(false)
bool(true)


类型运算符
instanceof 用于确定一个 PHP 变量是否属于某一类 class 的实例：
Example #1 对类使用 instanceof
<?php
  class MyClass{
  }

  class NotMyClass{
  }
  $a = new MyClass;

  var_dump($a instanceof MyClass);
  var_dump($a instanceof NotMyClass);
?>


instanceof　也可用来确定一个变量是不是继承自某一父类的子类的实例：
Example #2 对继承类使用 instanceof
<?php
  class ParentClass{
  }

  class MyClass extends ParentClass{
  }

  $a = new MyClass;

  var_dump($a instanceof MyClass);
  var_dump($a instanceof ParentClass);
?>


检查一个对象是否不是某个类的实例，可以使用逻辑运算符 not。
Example #3 使用 instanceof 检查对象不是某个类的实例
<?php
  class MyClass
  {
  }

  $a = new MyClass;
  var_dump(!($a instanceof stdClass));
?>


instanceof也可用于确定一个变量是不是实现了某个接口的对象的实例:
Example #4 对接口使用 instanceof
<?php
  interface MyInterface
  {
  }

  class MyClass implements MyInterface
  {
  }

  $a = new MyClass;

  var_dump($a instanceof MyClass);
  var_dump($a instanceof MyInterface);
?>


虽然 instanceof 通常直接与类名一起使用，但也可以使用对象或字符串变量：
Example #5 对其它变量使用 instanceof
<?php
  interface MyInterface
  {
  }

  class MyClass implements MyInterface
  {
  }

  $a = new MyClass;
  $b = new MyClass;
  $c = 'MyClass';
  $d = 'NotMyClass';

  var_dump($a instanceof $b); // $b is an object of class MyClass
  var_dump($a instanceof $c); // $c is a string 'MyClass'
  var_dump($a instanceof $d); // $d is a string 'NotMyClass'
?>


如果被检测的变量不是对象，instanceof 并不发出任何错误信息而是返回 FALSE。不允许用来检测常量。
Example #6 用 instanceof 检测其它变量
<?php
  $a = 1;
  $b = NULL;
  $c = imagecreate(5, 5);
  var_dump($a instanceof stdClass); // $a is an integer
  var_dump($b instanceof stdClass); // $b is NULL
  var_dump($c instanceof stdClass); // $c is a resource
  var_dump(FALSE instanceof stdClass);
?>


 然而 instanceof 的使用还有一些陷阱必须了解。在 PHP 5.1.0 之前，如果要检查的类名称不存在，instanceof 会调用 __autoload()。另外，如果该类没有被装载则会产生一个致命错误。可以通过使用动态类引用或用一个包含类名的字符串变量来避开这种问题：
Example #7 避免 PHP 5.0 中 instanceof 引起的类名查找和致命错误问题
<?php
  $d = 'NotMyClass';
  var_dump($a instanceof $d); // no fatal error here
?>




else if与selseif
必须要注意的是 elseif 与 else if 只有在类似上例中使用花括号的情况下才认为是完全相同。如果用冒号来定义 if/elseif 条件，那就不能用两个单词的 else if，否则 PHP 会产生解析错误。

<?php
  /* 不正确的使用方法： */
  if($a > $b):
      echo $a." is greater than ".$b;
  else if($a == $b): // 将无法编译
      echo "The above line causes a parse error.";
  endif;

  /* 正确的使用方法： */
  if($a > $b):
      echo $a." is greater than ".$b;
  elseif($a == $b): // 注意使用了一个单词的 elseif
      echo $a." equals ".$b;
  else:
      echo $a." is neither greater than or equal to ".$b;
  endif;
?>


PHP 提供了一些流程控制的替代语法，包括 if，while，for，foreach 和 switch。替代语法的基本形式是把左花括号（{）换成冒号（:），把右花括号（}）分别换成 endif;，endwhile;，endfor;，endforeach; 以及 endswitch;。
Note:不支持在同一个控制块内混合使用两种语法。 



<?php
  /*
   * 此数组将在遍历的过程中改变其中某些单元的值
   */
  $people = Array(
          Array('name' => 'Kalle', 'salt' => 856412), 
          Array('name' => 'Pierre', 'salt' => 215863)
          );

  for($i = 0; $i < count($people); ++$i){
      $people[$i]['salt'] = rand(000000, 999999);
  }
?>
以上代码可能执行很慢，因为每次循环时都要计算一遍数组的长度。由于数组的长度始终不变，可以用一个中间变量来储存数组长度以优化而不是不停调用 count()：
<?php
  $people = Array(
          Array('name' => 'Kalle', 'salt' => 856412), 
          Array('name' => 'Pierre', 'salt' => 215863)
          );

  for($i = 0, $size = count($people); $i < $size; ++$i){
      $people[$i]['salt'] = rand(000000, 999999);
  }
?>


list() 函数
把数组中的值赋给一些变量：
<?php
  $my_array = array("Dog","Cat","Horse");

  list($a, $b, $c) = $my_array;
  echo "I have several animals, a $a, a $b and a $c.";
?>



array each ( array &$array )
each — 返回数组中当前的键／值对并将数组指针向前移动一步 
注：each不是echo
在执行 each() 之后，数组指针将停留在数组中的下一个单元或者当碰到数组结尾时停留在最后一个单元。如果要再用 each 遍历数组，必须使用 reset()。

返回值:
返回 array 数组中当前指针位置的键／值对并向前移动数组指针。键值对被返回为四个单元的数组，键名为0，1，key和 value。单元 0 和 key 包含有数组单元的键名，1 和 value 包含有数据。
如果内部指针越过了数组的末端，则 each() 返回 FALSE。

Example #1 each() 例子
<?php
	$foo = array("bob", "fred", "jussi", "jouni", "egon", "marliese");
	$bar = each($foo);
	print_r($bar);
?>


each() 经常和 list() 结合使用来遍历数组，例如：

Example #2 用 each() 遍历数组
<?php
	$fruit = array('a' => 'apple', 'b' => 'banana', 'c' => 'cranberry');

	reset($fruit);
	while (list($key, $val) = each($fruit)) {
		echo "$key => $val\n";
	}
?>



 break 可以接受一个可选的数字参数来决定跳出几重循环。
<?php
  $arr = array('one', 'two', 'three', 'four', 'stop', 'five');
  while (list (, $val) = each($arr)) {
      if ($val == 'stop') {
          break;    /* You could also write 'break 1;' here. */
      }
      echo "$val<br />\n";
  }

  /* 使用可选参数 */
  $i = 0;
  while (++$i) {
      switch ($i) {
      case 5:
          echo "At 5<br />\n";
          break 1;  /* 只退出 switch. */
      case 10:
          echo "At 10; quitting<br />\n";
          break 2;  /* 退出 switch 和 while 循环 */
      default:
          break;
      }
  }
?>



continue 接受一个可选的数字参数来决定跳过几重循环到循环结尾。默认值是 1，即跳到当前循环末尾。
<?php
  while (list ($key, $value) = each($arr)) {
      if (!($key % 2)) { // skip odd members
          continue;
      }
      do_something_odd($value);
  }

  $i = 0;
  while ($i++ < 5) {
      echo "Outer<br />\n";
      while (1) {
          echo "Middle<br />\n";
          while (1) {
              echo "Inner<br />\n";
              continue 3;
          }
          echo "This never gets output.<br />\n";
      }
      echo "Neither does this.<br />\n";
  }
?>



include 和 return 语句
return.php
<?php
	$var = 'PHP';
	return $var;
?>

noreturn.php
<?php
	$var = 'PHP';
?>

testreturns.php
<?php
	$foo = include 'return.php';
	echo $foo; // prints 'PHP'
	$bar = include 'noreturn.php';
	echo $bar; // prints 1
?>



 goto 示例
<?php
  goto a;
  echo 'Foo';

  a:
  echo 'Bar';
?>
以上例程会输出：Bar


goto 跳出循环示例
<?php
  for($i=0,$j=50; $i<100; $i++) {
    while($j--) {
      if($j==17) goto end; 
    }  
  }
  echo "i = $i";
  end:
  echo 'j hit 17';
?>
以上例程会输出：j hit 17



当一个函数是有条件被定义时，必须在调用函数之前定义。
Example #2 有条件的函数
<?php
  $makefoo = true;
  /* 不能在此处调用foo()函数，
     因为它还不存在，但可以调用bar()函数。*/
  bar();
  if ($makefoo) {
    function foo(){
      echo "I don't exist until program execution reaches me.\n";
    }
  }
  /* 现在可以安全调用函数 foo()了，
     因为 $makefoo 值为真 */
  if ($makefoo) foo();
  function bar(){
    echo "I exist immediately upon program start.\n";
  }
?>


foreach ¶
Note:当 foreach 开始执行时，数组内部的指针会自动指向第一个单元。这意味着不需要在 foreach 循环之前调用 reset()。
由于 foreach 依赖内部数组指针，在循环中修改其值将可能导致意外的行为。 


 可以很容易地通过在 $value 之前加上 & 来修改数组的元素。此方法将以引用赋值而不是拷贝一个值。
<?php
  $arr = array(1, 2, 3, 4);
  foreach ($arr as &$value) {
      $value = $value * 2;
  }
  // $arr is now array(2, 4, 6, 8)
  unset($value); // 最后取消掉引用
?>


$value 的引用仅在被遍历的数组可以被引用时才可用（例如是个变量）。以下代码则无法运行：
<?php
  foreach (array(1, 2, 3, 4) as &$value) {
      $value = $value * 2;
  }
?>
Warning:数组最后一个元素的 $value 引用在 foreach 循环之后仍会保留。建议使用 unset() 来将其销毁。


用户可能注意到了以下的代码功能完全相同：
<?php
  $arr = array("one", "two", "three");
  reset($arr);
  while (list(, $value) = each($arr)) {
      echo "Value: $value<br>\n";
  }

  foreach ($arr as $value) {
      echo "Value: $value<br />\n";
  }
?>


以下代码功能也完全相同：
<?php
  $arr = array("one", "two", "three");
  reset($arr);
  while (list($key, $value) = each($arr)) {
      echo "Key: $key; Value: $value<br />\n";
  }

  foreach ($arr as $key => $value) {
      echo "Key: $key; Value: $value<br />\n";
  }
?>


示范用法的更多例子：
<?php
  /* foreach example 1: value only */
  $a = array(1, 2, 3, 17);

  foreach ($a as $v) {
     echo "Current value of \$a: $v.\n";
  }

  /* foreach example 2: value (with its manual access notation printed for illustration) */
  $a = array(1, 2, 3, 17);

  $i = 0; /* for illustrative purposes only */

  foreach ($a as $v) {
      echo "\$a[$i] => $v.\n";
      $i++;
  }

  /* foreach example 3: key and value */
  $a = array(
      "one" => 1,
      "two" => 2,
      "three" => 3,
      "seventeen" => 17
  );

  foreach ($a as $k => $v) {
      echo "\$a[$k] => $v.\n";
  }

  /* foreach example 4: multi-dimensional arrays */
  $a = array();
  $a[0][0] = "a";
  $a[0][1] = "b";
  $a[1][0] = "y";
  $a[1][1] = "z";

  foreach ($a as $v1) {
      foreach ($v1 as $v2) {
          echo "$v2\n";
      }
  }

  /* foreach example 5: dynamic arrays */
  foreach (array(1, 2, 3, 4, 5) as $v) {
      echo "$v\n";
  }
?>


list
(PHP 4, PHP 5, PHP 7)
list — 把数组中的值赋给一组变量 
像 array() 一样，这不是真正的函数，而是语言结构。 list() 可以在单次操作内就为一组变量赋值。 

Note:list() 仅能用于数字索引的数组，并假定数字索引从 0 开始。

Warning
PHP 5 里，list() 从最右边的参数开始赋值； PHP 7 里，list() 从最左边的参数开始赋值。
如果你用单纯的变量，不用担心这一点。 但是如果你用了具有索引的数组，通常你期望得到的结果和在 list() 中写的一样是从左到右的，但在 PHP 5 里实际上不是， 它是以相反顺序赋值的。
通常而言，不建议依赖于操作的顺序，在未来可能会再次发生修改。
  
Warning:在 list() 执行过程中修改数组（比如使用 list($a, $b) = $b）将会产生不可预知的结果。


Example #1 list() 例子
<?php
  $info = array('coffee', 'brown', 'caffeine');

  // 列出所有变量
  list($drink, $color, $power) = $info;
  echo "$drink is $color and $power makes it special.\n";

  // 列出他们的其中一个
  list($drink, , $power) = $info;
  echo "$drink has $power.\n";

  // 或者让我们跳到仅第三个
  list( , , $power) = $info;
  echo "I need $power!\n";

  // list() 不能对字符串起作用
  list($bar) = "abcde";
  var_dump($bar); // NULL
?>


Example #2 list() 用法的一个例子
<table>
 <tr>
  <th>Employee name</th>
  <th>Salary</th>
 </tr>

<?php
  $result = $pdo->query("SELECT id, name, salary FROM employees");
  while (list($id, $name, $salary) = $result->fetch(PDO::FETCH_NUM)) {
      echo " <tr>\n" .
            "  <td><a href=\"info.php?id=$id\">$name</a></td>\n" .
            "  <td>$salary</td>\n" .
            " </tr>\n";
  }
?>
</table>


Example #3 使用嵌套的 list()
<?php
  list($a, list($b, $c)) = array(1, array(2, 3));
  var_dump($a, $b, $c);
?>


Example #4 在 list() 中使用数组索引
<?php
  $info = array('coffee', 'brown', 'caffeine');
  list($a[0], $a[1], $a[2]) = $info;
  var_dump($a);
?>
产生如下输出（注意单元顺序和 list() 语法中所写的顺序的比较）：
Output of the above example in PHP 7:

array(3) {
  [0]=>
  string(6) "coffee"
  [1]=>
  string(5) "brown"
  [2]=>
  string(8) "caffeine"
}

Output of the above example in PHP 5:
array(3) {
  [2]=>
  string(8) "caffeine"
  [1]=>
  string(5) "brown"
  [0]=>
  string(6) "coffee"
}


Example #5 list() 和索引顺序定义
list() 使用 array 索引的顺序和它何时定义无关。
<?php
  $foo = array(2 => 'a', 'foo' => 'b', 0 => 'c');
  $foo[1] = 'd';
  list($x, $y, $z) = $foo;
  var_dump($foo, $x, $y, $z);
?>
得到输出（注意比较 list() 所写的元素顺序） 


用 list() 给嵌套的数组解包 ¶
(PHP 5 >= 5.5.0, PHP 7)
PHP 5.5 增添了遍历一个数组的数组的功能并且把嵌套的数组解包到循环变量中，只需将 list() 作为值提供。
例如：
<?php
  $array = [
      [1, 2],
      [3, 4],
  ];

  foreach ($array as list($a, $b)) {
      // $a contains the first element of the nested array,
      // and $b contains the second element.
      echo "A: $a; B: $b\n";
  }
?>


list() 中的单元可以少于嵌套数组的，此时多出来的数组单元将被忽略：
<?php
  $array = [
      [1, 2],
      [3, 4],
  ];

  foreach ($array as list($a)) {
      // Note that there is no $b here.
      echo "$a\n";
  }
?>


如果 list() 中列出的单元多于嵌套数组则会发出一条消息级别的错误信息：
<?php
  $array = [
      [1, 2],
      [3, 4],
  ];

  foreach ($array as list($a, $b, $c)) {
      echo "A: $a; B: $b; C: $c\n";
  }
?>


declare ¶
(PHP 4, PHP 5, PHP 7)
declare 结构用来设定一段代码的执行指令。declare 的语法和其它流程控制结构相似：
declare (directive)
    statement

declare 代码段中的 statement 部分将被执行——怎样执行以及执行中有什么副作用出现取决于 directive 中设定的指令。


<?php
  // these are the same:

  // you can use this:
  declare(ticks=1) {
      // entire script here
  }

  // or you can use this:
  declare(ticks=1);
  // entire script here
?>


Example #1 Tick 的用法示例
<?php
  declare(ticks=1);

  // A function called on each tick event
  function tick_handler()
  {
      echo "tick_handler() called\n";
  }

  register_tick_function('tick_handler');

  $a = 1;

  if ($a > 0) {
      $a += 2;
      print($a);
  }
?>




Example #2 Ticks 的用法示例
<?php
  function tick_handler()
  {
    echo "tick_handler() called\n";
  }

  $a = 1;
  tick_handler();

  if ($a > 0) {
      $a += 2;
      tick_handler();
      print($a);
      tick_handler();
  }
  tick_handler();
?>

可以用 encoding 指令来对每段脚本指定其编码方式。


Example #3 对脚本指定编码方式
<?php
  declare(encoding='ISO-8859-1');
  // code here
?>


return ¶
(PHP 4, PHP 5, PHP 7)
如果在一个函数中调用 return 语句，将立即结束此函数的执行并将它的参数作为函数的值返回。return 也会终止 eval() 语句或者脚本文件的执行。

如果在全局范围中调用，则当前脚本文件中止运行。如果当前脚本文件是被 include 的或者 require 的，则控制交回调用文件。此外，如果当前脚本是被 include 的，则 return 的值会被当作 include 调用的返回值。如果在主脚本文件中调用 return，则脚本中止运行。如果当前脚本文件是在 php.ini 中的配置选项 auto_prepend_file 或者 auto_append_file 所指定的，则此脚本文件中止运行。

更多信息见返回值。
Note: 注意既然 return 是语言结构而不是函数，因此其参数没有必要用括号将其括起来。通常都不用括号，实际上也应该不用，这样可以降低 PHP 的负担。 

Note: 如果没有提供参数，则一定不能用括号，此时返回 NULL。如果调用 return 时加上了括号却又没有参数会导致解析错误。 

Note: 当用引用返回值时永远不要使用括号，这样行不通。只能通过引用返回变量，而不是语句的结果。如果使用 return ($a); 时其实不是返回一个变量，而是表达式 ($a) 的值（当然，此时该值也正是 $a 的值）。 



函数中的函数
<?php
  function foo(){
    function bar(){
      echo "I don't exist until foo() is called.\n";
    }
  }
  /* 现在还不能调用bar()函数，因为它还不存在 */
  foo();
  /* 现在可以调用bar()函数了，因为foo()函数
     的执行使得bar()函数变为已定义的函数 */
  bar();
?>


通过引用传递参数 ¶

默认情况下，函数参数通过值传递（因而即使在函数内部改变参数的值，它并不会改变函数外部的值）。如果希望允许函数修改它的参数值，必须通过引用传递参数。

如果想要函数的一个参数总是通过引用传递，可以在函数定义中该参数的前面加上符号 &：
Example #2 用引用传递函数参数
<?php
  function add_some_extra(&$string)
  {
      $string .= 'and something extra.';
  }
  $str = 'This is a string, ';
  add_some_extra($str);
  echo $str;    // outputs 'This is a string, and something extra.'
?>


PHP 还允许使用数组 array 和特殊类型 NULL 作为默认参数，例如：
Example #4 使用非标量类型作为默认参数
<?php
  function makecoffee($types = array("cappuccino"), $coffeeMaker = NULL)
  {
      $device = is_null($coffeeMaker) ? "hands" : $coffeeMaker;
      return "Making a cup of ".join(", ", $types)." with $device.\n";
  }
  echo makecoffee();
  echo makecoffee(array("cappuccino", "lavazza"), "teapot");
?>
默认值必须是常量表达式，不能是诸如变量，类成员，或者函数调用等。 


 注意当使用默认参数时，任何默认参数必须放在任何非默认参数的右侧；否则，函数将不会按照预期的情况工作。考虑下面的代码片断：
Example #5 函数默认参数的不正确用法
<?php
  function test($type = "king",$x){
      return " $type >>>>> $x";
  }
  echo test("good");   // won't work as expected
?>

现在，比较上面的例子和这个例子：
Example #6 函数默认参数正确的用法
<?php
  function makeyogurt($flavour, $type = "acidophilus")
  {
      return "Making a bowl of $type $flavour.\n";
  }

  echo makeyogurt("raspberry");   // works as expected
?>

函数的参数 类型声明 ¶
Note:在PHP 5中，类型声明也被称为类型提示。

类型声明允许函数在调用时要求参数为特定类型。 如果给出的值类型不对，那么将会产生一个错误： 在PHP 5中，这将是一个可恢复的致命错误，而在PHP 7中将会抛出一个TypeError异常。

为了指定一个类型声明，类型应该加到参数名前。这个声明可以通过将参数的默认值设为NULL来实现允许传递NULL。 


Example #7 Basic class type declaration
<?php
  class C {}
  class D extends C {}

  // This doesn't extend C.
  class E {}

  function f(C $c) {
      echo get_class($c)."\n";
  }

  f(new C);
  f(new D);
  f(new E);
?>


Example #8 Basic interface type declaration
<?php
  interface I { public function f(); }
  class C implements I { public function f() {} }

  // This doesn't implement I.
  class E {}

  function f(I $i) {
      echo get_class($i)."\n";
  }

  f(new C);
  f(new E);
?>


Example #9 Nullable type declaration
<?php
  class C {}

  function f(C $c = null) {
      var_dump($c);
  }

  f(new C);
  f(null);
?>


函数的参数 严格类型 ¶

默认情况下，如果能做到的话，PHP将会强迫错误类型的值转为函数期望的标量类型。 例如，一个函数的一个参数期望是string，但传入的是integer，最终函数得到的将会是一个string类型的值。

可以基于每一个文件开启严格模式。在严格模式中，只有一个与类型声明完全相符的变量才会被接受，否则将会抛出一个TypeError。 唯一的一个例外是可以将integer传给一个期望float的函数。

使用 declare 语句和strict_types 声明来启用严格模式： 


Note:严格类型仅用于标量类型声明，也正是因为如此，这需要PHP 7.0.0 或更新版本，因为标量类型声明也是在那个版本中添加的。 
Example #10 Strict typing
<?php
  declare(strict_types=1);

  function sum(int $a, int $b) {
      return $a + $b;
  }

  var_dump(sum(1, 2));
  var_dump(sum(1.5, 2.5));
?>

Example #11 Weak typing
<?php
  function sum(int $a, int $b) {
      return $a + $b;
  }

  var_dump(sum(1, 2));

  // These will be coerced to integers: note the output below!
  var_dump(sum(1.5, 2.5));
?>
以上例程会输出：
int(3)
int(3)


Example #12 Catching TypeError
<?php
  declare(strict_types=1);

  function sum(int $a, int $b) {
      return $a + $b;
  }

  try {
      var_dump(sum(1, 2));
      var_dump(sum(1.5, 2.5));
  } catch (TypeError $e) {
      echo 'Error: '.$e->getMessage();
  }
?>
以上例程会输出：
int(3)
Error: Argument 1 passed to sum() must be of the type integer, float given, called in - on line 10


可变数量的参数列表 ¶
PHP 在用户自定义函数中支持可变数量的参数列表。在 PHP 5.6 及以上的版本中，由 ... 语法实现；在 PHP 5.5 及更早版本中，使用函数 func_num_args()，func_get_arg()，和 func_get_args() 。 

<?php
  function sum(...$numbers) {
      $acc = 0;
      foreach ($numbers as $n) {
          $acc += $n;
      }
      return $acc;
  }

  echo sum(1, 2, 3, 4);
?>
以上例程会输出：
10




Example #14 Using ... to provide arguments
<?php
  function add($a, $b) {
      return $a + $b;
  }

  echo add(...[1, 2])."\n";

  $a = [1, 2];
  echo add(...$a);
?>

以上例程会输出：
3
3


Example #15 Type hinted variable arguments
<?php
  function total_intervals($unit, DateInterval ...$intervals) {
      $time = 0;
      foreach ($intervals as $interval) {
          $time += $interval->$unit;
      }
      return $time;
  }

  $a = new DateInterval('P1D');
  $b = new DateInterval('P2D');
  echo total_intervals('d', $a, $b).' days';

  // This will fail, since null isn't a DateInterval object.
  echo total_intervals('d', null);
?>
以上例程会输出：
3 days
Catchable fatal error: Argument 2 passed to total_intervals() must be an instance of DateInterval, null given, called in - on line 14 and defined in - on line 2


在PHP 5.5及更早版本中访问变量参数
Example #16 Accessing variable arguments in PHP 5.5 and earlier
<?php
  function sum() {
      $acc = 0;
      foreach (func_get_args() as $n) {
          $acc += $n;
      }
      return $acc;
  }

  echo sum(1, 2, 3, 4);
?>


 函数不能返回多个值，但可以通过返回一个数组来得到类似的效果。
Example #2 返回一个数组以得到多个返回值
<?php
  function small_numbers(){
      return array (0, 1, 2);
  }
  list ($zero, $one, $two) = small_numbers();
?>



 从函数返回一个引用，必须在函数声明和指派返回值给一个变量时都使用引用运算符 &：
Example #3 从函数返回一个引用
<?php
  function &returns_reference(){
      return $someref;
  }

  $newref =& returns_reference();
?>


PHP 支持可变函数的概念。这意味着如果一个变量名后有圆括号，PHP 将寻找与变量的值同名的函数，并且尝试执行它。可变函数可以用来实现包括回调函数，函数表在内的一些用途。 
e.g:
<?php
  function test(){
    return 'YES GOOD!';
  }
  $goTest='test';
  echo $goTest();
?>


也可以用可变函数的语法来调用一个对象的方法。
<?php
  class Foo{
      function Variable(){
          $name = 'Bar';
          $this->$name(); // This calls the Bar() method
      }

      function Bar(){
          echo "This is Bar";
      }
  }

  $foo = new Foo();
  $funcname = "Variable";
  $foo->$funcname();   // This calls $foo->Variable()
?>


 As of PHP 5.4.0, you can call any callable stored in a variable.
Example #4 Complex callables
<?php
  class Foo {
    static function bar() {
      echo "bar\n";
    } 
    function baz() {
      echo "baz\n";
    } 
  } 

  $func = array("Foo", "bar");
  $func(); // prints "bar"
  $func = array(new Foo, "baz");
  $func(); // prints "baz"
  $func = "Foo::bar";
  $func(); // prints "bar" as of PHP 7.0.0; prior, it raised a fatal error
?>



匿名函数（Anonymous functions），也叫闭包函数（closures），允许 临时创建一个没有指定名称的函数。最经常用作回调函数（callback）参数的值。当然，也有其它应用的情况。 
 
 匿名函数目前是通过 Closure 类来实现的。
Example #1 匿名函数示例:
注：preg_replace_callback -- 用回调函数执行正则表达式的搜索和替换
<?php
  echo preg_replace_callback('~-([a-z])~', function ($match) {
      return strtoupper($match[1]);
  }, 'hello-world');
  // 输出 helloWorld
?>


 闭包函数也可以作为变量的值来使用。PHP 会自动把此种表达式转换成内置类 Closure 的对象实例。把一个 closure 对象赋值给一个变量的方式与普通变量赋值的语法是一样的，最后也要加上分号：
Example #2 匿名函数变量赋值示例
<?php
  $greet = function($name)
  {
      printf("Hello %s\r\n", $name);
  };

  $greet('World');
  $greet('PHP');
?>


 闭包可以从父作用域中继承变量。 任何此类变量都应该用 use 语言结构传递进去。 PHP 7.1 起，不能传入此类变量： superglobals、 $this 或者和参数重名。

Example #3 从父作用域继承变量
<?php
  $message = 'hello';

  // 没有 "use"
  $example = function () {
      var_dump($message);
  };
  echo $example();

  // 继承 $message
  $example = function () use ($message) {
      var_dump($message);
  };
  echo $example();

  // Inherited variable's value is from when the function
  // is defined, not when called
  $message = 'world';
  echo $example();

  // Reset message
  $message = 'hello';

  // Inherit by-reference
  $example = function () use (&$message) {
      var_dump($message);
  };
  echo $example();

  // The changed value in the parent scope
  // is reflected inside the function call
  $message = 'world';
  echo $example();

  // Closures can also accept regular arguments
  $example = function ($arg) use ($message) {
      var_dump($arg . ' ' . $message);
  };
  $example("hello");
?>


 这些变量都必须在函数或类的头部声明。 从父作用域中继承变量与使用全局变量是不同的。全局变量存在于一个全局的范围，无论当前在执行的是哪个函数。而 闭包的父作用域是定义该闭包的函数（不一定是调用它的函数）。示例如下：

Example #4 Closures 和作用域
<?php
  // 一个基本的购物车，包括一些已经添加的商品和每种商品的数量。
  // 其中有一个方法用来计算购物车中所有商品的总价格，该方法使
  // 用了一个 closure 作为回调函数。
  class Cart
  {
      const PRICE_BUTTER  = 1.00;
      const PRICE_MILK    = 3.00;
      const PRICE_EGGS    = 6.95;

      protected   $products = array();
      
      public function add($product, $quantity)
      {
          $this->products[$product] = $quantity;
      }
      
      public function getQuantity($product)
      {
          return isset($this->products[$product]) ? $this->products[$product] :
                 FALSE;
      }
      
      public function getTotal($tax)
      {
          $total = 0.00;
          
          $callback =
              function ($quantity, $product) use ($tax, &$total)
              {
                  $pricePerItem = constant(__CLASS__ . "::PRICE_" .
                      strtoupper($product));
                  $total += ($pricePerItem * $quantity) * ($tax + 1.0);
              };
          
          array_walk($this->products, $callback);
          return round($total, 2);;
      }
  }

  $my_cart = new Cart;

  // 往购物车里添加条目
  $my_cart->add('butter', 1);
  $my_cart->add('milk', 3);
  $my_cart->add('eggs', 6);

  // 打出出总价格，其中有 5% 的销售税.
  print $my_cart->getTotal(0.05) . "\n";
  // 最后结果是 54.29
?>


Example #5 Automatic binding of $this
<?php
  class Test{
      public function testing(){
          return function() {
              var_dump($this);
          };
      }
  }

  $object = new Test;
  $function = $object->testing();
  $function();
?>


从PHP 5.4.0开始，当在类的上下文中声明时，当前类被自动绑定到它，使得$可以在函数的范围内使用。 如果不需要自动绑定当前类，则可以使用静态匿名函数

从PHP 5.4开始，静态地声明匿名函数。 这样可以防止他们将当前类自动绑定到它们。 对象在运行时也可能并不绑定到它们。
Example #6 Attempting to use $this inside a static anonymous function
<?php
  class Foo {
    function __construct() {
      $func = static function() {
        var_dump($this);
      } ;
      $func();
    } 
  } ;
  new Foo();
?>
以上例程会输出：
Notice: Undefined variable: this in %s on line %d
NULL


Example #7 Attempting to bind an object to a static anonymous function
<?php
  $func = static function() {
    // function body
  } ;
  $func = $func -> bindTo(new StdClass);
  $func();
?>
以上例程会输出：
Warning: Cannot bind an instance to a static closure in %s on line %d



-------------类Class--start>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


定义：每个类的定义都以关键字 class 开头，后面跟着类名，后面跟着一对花括号，里面包含有类的属性与方法的定义。


一个类可以包含有属于自己的常量，变量（称为“属性”）以及函数（称为“方法”）。
<?php
  class SimpleClass {
    // property declaration
    public $var = 'a default value'; 
    // method declaration
    public function displayVar() {
      echo $this -> var;
    } 
  } 
?>



当一个方法在类定义内部被调用时，有一个可用的伪变量 $this。$this 是一个到主叫对象的引用（通常是该方法所从属的对象，但如果是从第二个对象静态调用时也可能是另一个对象）。 
Example #2 $this 伪变量的示例
<?php
  class A {
    function foo() {
      if (isset($this)) {
        echo '$this is defined (';
        echo get_class($this);
        echo ")\n";
      } else {
        echo "\$this is not defined.\n";
      } 
    } 
  } 

  class B {
    function bar() {
      // Note: the next line will issue a warning if E_STRICT is enabled.
      A :: foo();
    } 
  } 

  $a = new A();
  $a -> foo();
  // Note: the next line will issue a warning if E_STRICT is enabled.
  A :: foo();
  $b = new B();
  $b -> bar();
  // Note: the next line will issue a warning if E_STRICT is enabled.
  B :: bar();
?>


要创建一个类的实例，必须使用 new 关键字。当创建新对象时该对象总是被赋值，除非该对象定义了构造函数并且在出错时抛出了一个异常。类应在被实例化之前定义（某些情况下则必须这样）。 
在类定义内部，可以用 new self 和 new parent 创建新对象。
Example #3 创建一个实例
<?php
  $instance = new SimpleClass();

  // 也可以这样做：
  $className = 'Foo';
  $instance = new $className(); // Foo()
?>



 当把一个对象已经创建的实例赋给一个新变量时，新变量会访问同一个实例，就和用该对象赋值一样。此行为和给函数传递入实例时一样。可以用克隆给一个已创建的对象建立一个新实例。
Example #4 对象赋值
<?php
  $instance = new SimpleClass();

  $assigned   =  $instance;
  $reference  =& $instance;

  $instance->var = '$assigned will have this value';

  $instance = null; // $instance and $reference become null

  var_dump($instance);
  var_dump($reference);
  var_dump($assigned);
?>


Example #5 创建新对象
<?php
  class Test {
    static public function getNew() {
      return new static;
    } 
  } 

  class Child extends Test {
  } 

  $obj1 = new Test();
  $obj2 = new $obj1;
  var_dump($obj1 !== $obj2);

  $obj3 = Test :: getNew();
  var_dump($obj3 instanceof Test);

  $obj4 = Child :: getNew();
  var_dump($obj4 instanceof Child);
?>


extends ¶
一个类可以在声明中用 extends 关键字继承另一个类的方法和属性。PHP不支持多重继承，一个类只能继承一个基类。
被继承的方法和属性可以通过用同样的名字重新声明被覆盖。但是如果父类定义方法时使用了 final，则该方法不可被覆盖。可以通过 parent:: 来访问被覆盖的方法或属性。
当覆盖方法时，参数必须保持一致否则 PHP 将发出 E_STRICT 级别的错误信息。但构造函数例外，构造函数可在被覆盖时使用不同的参

Example #6 简单的类继承
<?php
  class SimpleClass {
    // property declaration
    public $var = 'a default value'; 
    // method declaration
    public function displayVar() {
      echo $this -> var;
    } 
  } 

  class ExtendClass extends SimpleClass {
    // Redefine the parent method
    function displayVar() {
      echo "Extending class\n";
      parent :: displayVar();
    } 
  } 

  $extended = new ExtendClass();
  $extended -> displayVar();
?>


::class ¶
自 PHP 5.5 起，关键词 class 也可用于类名的解析。使用 ClassName::class 你可以获取一个字符串，包含了类 ClassName 的完全限定名称。这对使用了 命名空间 的类尤其有用。
Example #7 类名的解析
<?php
  namespace NS {
      class ClassName {
      }
      
      echo ClassName::class;
  }
?>



属性 ¶
类的变量成员叫做“属性”，或者叫“字段”、“特征”，在本文档统一称为“属性”。属性声明是由关键字 public，protected 或者 private 开头，然后跟一个普通的变量声明来组成。属性中的变量可以初始化，但是初始化的值必须是常数，这里的常数是指 PHP 脚本在编译阶段时就可以得到其值，而不依赖于运行时的信息才能求值。 

Note:
为了向后兼容 PHP 4，PHP 5 声明属性依然可以直接使用关键字 var 来替代（或者附加于）public，protected 或 private。但是已不再需要 var 了。在 PHP 5.0 到 5.1.3，var 会被认为是废弃的，而且抛出 E_STRICT 警告，但是 5.1.3 之后就不再认为是废弃，也不会抛出警告。
如果直接使用 var 声明属性，而没有用 public，protected 或 private 之一，PHP 5 会将其视为 public。

在类的成员方法里面，可以用 ->（对象运算符）：$this->property（其中 property 是该属性名）这种方式来访问非静态属性。静态属性则是用 ::（双冒号）：self::$property 来访问 


Example #1 属性声明
<?php
  class SimpleClass {
    // 错误的属性声明
    public $var1 = 'hello ' . 'world';
    public $var2 = <<<EOD
hello world
EOD;
  public $var3 = 1 + 2;
  public $var4 = self :: myStaticMethod();
  public $var5 = $myVar; 
  // 正确的属性声明
  public $var6 = myConstant;
  public $var7 = array(true, false); 
  // 在 PHP 5.3.0 及之后，下面的声明也正确
  public $var8 = <<<' EOD'
hello world
EOD;
}
?>



 跟 heredocs 不同，nowdocs 可在任何静态数据上下文中使用，包括属性声明。
Example #2 示例：使用 nowdoc 初始化属性
<?php
  class foo {
     // 自 5.3.0 起
     public $bar = <<<'EOT'
  bar
EOT;
}
?>



类常量 ¶

可以把在类中始终保持不变的值定义为常量。在定义和使用常量的时候不需要使用 $ 符号。
常量的值必须是一个定值，不能是变量，类属性，数学运算的结果或函数调用。 

php中const定义常量
const 常量 
1.在定义时必须被初始值，
2.前面不加任何修饰符
3.变量名字母一般都大写
4.常量可以被子类继承
5.一个常量是属于一个类的，而不是某个对象的
作用：当某些值是固定不变的，就用const
const 定义的常量和define()定义的常量的区别？
希望一个成员变量不被修改 例如圆周率 3.1415926
定义：const 常量名=值; 没有$符
访问：类名 ::常量名 或 接口名::常量名


定义和使用一个类常量
<?php
  class MyClass {
    const constant = 'constant value';

    function showConstant() {
      echo self :: constant . "\n";
    } 
  } 

  echo MyClass :: constant . "\n";

  $classname = "MyClass";
  echo $classname :: constant . "\n"; // 自 5.3.0 起

  $class = new MyClass();
  $class -> showConstant();

  echo $class :: constant . "\n"; // 自 PHP 5.3.0 起
?>
 

Example #2 静态数据示例
<?php
  class foo {
    // 自 PHP 5.3.0 起
    const bar = <<<' EOT'
  bar
EOT;
}
?>


类的自动加载 ¶

在编写面向对象（OOP） 程序时，很多开发者为每个类新建一个 PHP 文件。 这会带来一个烦恼：每个脚本的开头，都需要包含（include）一个长长的列表（每个类都有个文件）。

在 PHP 5 中，已经不再需要这样了。 spl_autoload_register() 函数可以注册任意数量的自动加载器，当使用尚未被定义的类（class）和接口（interface）时自动去加载。通过注册自动加载器，脚本引擎在 PHP 出错失败前有了最后一个机会加载所需的类。
Tip

尽管 __autoload() 函数也能自动加载类和接口，但更建议使用 spl_autoload_register() 函数。 spl_autoload_register() 提供了一种更加灵活的方式来实现类的自动加载（同一个应用中，可以支持任意数量的加载器，比如第三方库中的）。因此，不再建议使用 __autoload() 函数，在以后的版本中它可能被弃用。

Note:自动加载不可用于 PHP 的 CLI 交互模式。 

Note:如果类名比如被用于 call_user_func()，则它可能包含一些危险的字符，比如 ../。 建议您在这样的函数中不要使用用户的输入，起码需要在 __autoload() 时验证下输入。 


Example #1 自动加载示例
本例尝试分别从 MyClass1.php 和 MyClass2.php 文件中加载 MyClass1 和 MyClass2 类。
<?php
  spl_autoload_register(function ($class_name) {
      require_once $class_name . '.php';
  });

  $obj  = new MyClass1();
  $obj2 = new MyClass2();
?>





Example #2 另一个例子
本例尝试加载接口 ITest。
<?php
  spl_autoload_register(function ($name) {
      var_dump($name);
  });

  class Foo implements ITest {
  }

  /*
  string(5) "ITest"

  Fatal error: Interface 'ITest' not found in ...
  */
?>


Example #3 自动加载在 PHP 5.3.0+ 中的异常处理
本例抛出一个异常并在 try/catch 语句块中演示。
<?php
  spl_autoload_register(function ($name) {
      echo "Want to load $name.\n";
      throw new Exception("Unable to load $name.");
  });

  try {
      $obj = new NonLoadableClass();
  } catch (Exception $e) {
      echo $e->getMessage(), "\n";
  }
?>
以上例程会输出：
Want to load NonLoadableClass.
Unable to load NonLoadableClass.


Example #4 自动加载在 PHP 5.3.0+ 中的异常处理 - 没有自定义异常机制
本例将一个异常抛给不存在的自定义异常处理函数。
<?php
  spl_autoload_register(function ($name) {
      echo "Want to load $name.\n";
      throw new MissingException("Unable to load $name.");
  });

  try {
      $obj = new NonLoadableClass();
  } catch (Exception $e) {
      echo $e->getMessage(), "\n";
  }
?>

以上例程会输出：
Want to load NonLoadableClass.
Want to load MissingException.
Fatal error: Class 'MissingException' not found in testMissingException.php on line 4





构造函数 ¶
void __construct ([ mixed $args [, $... ]] )
PHP 5 允行开发者在一个类中定义一个方法作为构造函数。具有构造函数的类会在每次创建新对象时先调用此方法，所以非常适合在使用对象之前做一些初始化工作


Note: 如果子类中定义了构造函数则不会隐式调用其父类的构造函数。要执行父类的构造函数，需要在子类的构造函数中调用 parent::__construct()。如果子类没有定义构造函数则会如同一个普通的类方法一样从父类继承（假如没有被定义为 private 的话）。 

Example #1 使用新标准的构造函数
<?php
  class BaseClass {
     function __construct() {
         print "In BaseClass constructor\n";
     }
  }

  class SubClass extends BaseClass {
     function __construct() {
         parent::__construct();
         print "In SubClass constructor\n";
     }
  }

  class OtherSubClass extends BaseClass {
      // inherits BaseClass's constructor
  }

  // In BaseClass constructor
  $obj = new BaseClass();

  // In BaseClass constructor
  // In SubClass constructor
  $obj = new SubClass();

  // In BaseClass constructor
  $obj = new OtherSubClass();
?>


自 PHP 5.3.3 起，在命名空间中，与类名同名的方法不再作为构造函数。这一改变不影响不在命名空间中的类。

Example #2 Constructors in namespaced classes
<?php
  namespace Foo;
  class Bar {
      public function Bar() {
          // treated as constructor in PHP 5.3.0-5.3.2
          // treated as regular method as of PHP 5.3.3
      }
  }
?>

析构函数 ¶
void __destruct ( void )

PHP 5 引入了析构函数的概念，这类似于其它面向对象的语言，如 C++。析构函数会在到某个对象的所有引用都被删除或者当对象被显式销毁时执行。

Example #3 析构函数示例
<?php
  class MyDestructableClass {
     function __construct() {
         print "In constructor\n";
         $this->name = "MyDestructableClass";
     }

     function __destruct() {
         print "Destroying " . $this->name . "\n";
     }
  }

  $obj = new MyDestructableClass();
?>

注：析构函数实现与构造函数相反的功能，就是回收在构造函数中所申请的内存空间。



访问控制（可见性） ¶
对属性或方法的访问控制，是通过在前面添加关键字 public（公有），protected（受保护）或 private（私有）来实现的。被定义为公有的类成员可以在任何地方被访问。被定义为受保护的类成员则可以被其自身以及其子类和父类访问。被定义为私有的类成员则只能被其定义所在的类访问。 


 类属性必须定义为公有，受保护，私有之一。如果用 var 定义，则被视为公有。

Example #1 属性声明
<?php
  /**
   * Define MyClass
   */
  class MyClass
  {
      public $public = 'Public';
      protected $protected = 'Protected';
      private $private = 'Private';

      function printHello()
      {
          echo $this->public;
          echo $this->protected;
          echo $this->private;
      }
  }

  $obj = new MyClass();
  echo $obj->public; // 这行能被正常执行
  echo $obj->protected; // 这行会产生一个致命错误
  echo $obj->private; // 这行也会产生一个致命错误
  $obj->printHello(); // 输出 Public、Protected 和 Private

  /**
   * Define MyClass2
   */
  class MyClass2 extends MyClass
  {
      // 可以对 public 和 protected 进行重定义，但 private 而不能
      protected $protected = 'Protected2';

      function printHello()
      {
          echo $this->public;
          echo $this->protected;
          echo $this->private;
      }
  }

  $obj2 = new MyClass2();
  echo $obj2->public; // 这行能被正常执行
  echo $obj2->private; // 未定义 private
  echo $obj2->protected; // 这行会产生一个致命错误
  $obj2->printHello(); // 输出 Public、Protected2 和 Undefined
?>




方法的访问控制 ¶

类中的方法可以被定义为公有，私有或受保护。如果没有设置这些关键字，则该方法默认为公有。

Example #2 方法声明
<?php
    /**
     * Define MyClass
     */
    class MyClass
    {
        // 声明一个公有的构造函数
        public function __construct() { }

        // 声明一个公有的方法
        public function MyPublic() { }

        // 声明一个受保护的方法
        protected function MyProtected() { }

        // 声明一个私有的方法
        private function MyPrivate() { }

        // 此方法为公有
        function Foo()
        {
            $this->MyPublic();
            $this->MyProtected();
            $this->MyPrivate();
        }
    }

    $myclass = new MyClass;
    $myclass->MyPublic(); // 这行能被正常执行
    $myclass->MyProtected(); // 这行会产生一个致命错误
    $myclass->MyPrivate(); // 这行会产生一个致命错误
    $myclass->Foo(); // 公有，受保护，私有都可以执行


    /**
     * Define MyClass2
     */
    class MyClass2 extends MyClass
    {
        // 此方法为公有
        function Foo2()
        {
            $this->MyPublic();
            $this->MyProtected();
            $this->MyPrivate(); // 这行会产生一个致命错误
        }
    }

    $myclass2 = new MyClass2;
    $myclass2->MyPublic(); // 这行能被正常执行
    $myclass2->Foo2(); // 公有的和受保护的都可执行，但私有的不行

    class Bar 
    {
        public function test() {
            $this->testPrivate();
            $this->testPublic();
        }

        public function testPublic() {
            echo "Bar::testPublic\n";
        }
        
        private function testPrivate() {
            echo "Bar::testPrivate\n";
        }
    }

    class Foo extends Bar 
    {
        public function testPublic() {
            echo "Foo::testPublic\n";
        }
        
        private function testPrivate() {
            echo "Foo::testPrivate\n";
        }
    }

    $myFoo = new foo();
    $myFoo->test(); // Bar::testPrivate 
                    // Foo::testPublic
?>



其它对象的访问控制 ¶
同一个类的对象即使不是同一个实例也可以互相访问对方的私有与受保护成员。这是由于在这些对象的内部具体实现的细节都是已知的。
Example #3 访问同一个对象类型的私有成员
<?php
  class Test {
    private $foo;

    public function __construct($foo) {
      $this -> foo = $foo;
    } 

    private function bar() {
      echo 'Accessed the private method.';
    } 

    public function baz(Test $other) {
      // We can change the private property:
      $other -> foo = 'hello';
      var_dump($other -> foo); 
      // We can also call the private method:
      $other -> bar();
    } 
  } 

  $test = new Test('test');

  $test -> baz(new Test('other'));
?>



对象继承
Note:

除非使用了自动加载，否则一个类必须在使用之前被定义。如果一个类扩展了另一个，则父类必须在子类之前被声明。此规则适用于类继承其它类与接口。 
<?php
  class foo {
    public function printItem($string) {
      echo 'Foo: ' . $string . PHP_EOL;
    } 

    public function printPHP() {
      echo 'PHP is great.' . PHP_EOL;
    } 
  } 

  class bar extends foo {
    public function printItem($string) {
      echo 'Bar: ' . $string . PHP_EOL;
    } 
  } 

  $foo = new foo();
  $bar = new bar();
  $foo -> printItem('baz'); // Output: 'Foo: baz'
  $foo -> printPHP(); // Output: 'PHP is great' 
  $bar -> printItem('baz'); // Output: 'Bar: baz'
  $bar -> printPHP(); // Output: 'PHP is great'
?>



范围解析操作符 （::） ¶
范围解析操作符（也可称作 Paamayim Nekudotayim）或者更简单地说是一对冒号，可以用于访问静态成员，类常量，还可以用于覆盖类中的属性和方法
Example #1 在类的外部使用 :: 操作符
<?php
  class MyClass {
      const CONST_VALUE = 'A constant value';
  }

  $classname = 'MyClass';
  echo $classname::CONST_VALUE; // 自 PHP 5.3.0 起

  echo MyClass::CONST_VALUE;
?>



Example #2 在类定义内部使用 ::
<?php
  class MyClass {
      const CONST_VALUE = 'A constant value<br />';
  }

  class OtherClass extends MyClass
  {
      public static $my_static = 'static var';

      public static function doubleColon() {
          echo parent::CONST_VALUE . "<Br />";
          echo self::$my_static . "<br />";
      }
  }

  $classname = 'OtherClass';
  echo $classname::doubleColon(); // 自 PHP 5.3.0 起

  OtherClass::doubleColon();
?>




 当一个子类覆盖其父类中的方法时，PHP 不会调用父类中已被覆盖的方法。是否调用父类的方法取决于子类。这种机制也作用于构造函数和析构函数，重载以及魔术方法。
Example #3 调用父类的方法
<?php
  class MyClass {
    protected function myFunc() {
      echo "MyClass::myFunc()\n";
    } 
  } 

  class OtherClass extends MyClass {
    // 覆盖了父类的定义
    public function myFunc() {
      // 但还是可以调用父类中被覆盖的方法
      parent :: myFunc();
      echo "OtherClass::myFunc()\n";
    } 
  } 

  $class = new OtherClass();
  $class -> myFunc();
?>



Static（静态）关键字 ¶
本页说明了用 static 关键字来定义静态方法和属性。static 也可用于定义静态变量以及后期静态绑定。参见上述页面了解 static 在其中的用法。
声明类属性或方法为静态，就可以不实例化类而直接访问。静态属性不能通过一个类已实例化的对象来访问（但静态方法可以）。
为了兼容 PHP 4，如果没有指定访问控制，属性和方法默认为公有。
由于静态方法不需要通过对象即可调用，所以伪变量 $this 在静态方法中不可用。
静态属性不可以由对象通过 -> 操作符来访问.
就像其它所有的 PHP 静态变量一样，静态属性只能被初始化为文字或常量，不能使用表达式。所以可以把静态属性初始化为整数或数组，但不能初始化为另一个变量或函数返回值，也不能指向一个对象。

Example #1 静态属性示例
<?php
  class Foo {
    public static $my_static = 'fooline:five5<br />';

    public function staticValue() {
      return self :: $my_static;
    } 
  } 

  class Bar extends Foo {
    public function fooStatic() {
      return parent :: $my_static;
    } 
  } 



  print Foo::$my_static . "\n";

  $foo = new Foo();
  print $foo->staticValue() . "\n";
  print $foo->my_static . "\n";      // Undefined "Property" my_static 

  print $foo::$my_static . "\n";
  $classname = 'Foo';
  print $classname::$my_static . "\n"; // As of PHP 5.3.0

  print Bar::$my_static . "\n";
  $bar = new Bar();
  print $bar->fooStatic() . "\n";
?>



抽象类 ¶

PHP 5 支持抽象类和抽象方法。定义为抽象的类不能被实例化。任何一个类，如果它里面至少有一个方法是被声明为抽象的，那么这个类就必须被声明为抽象的。被定义为抽象的方法只是声明了其调用方式（参数），不能定义其具体的功能实现。 
Example #1 抽象类示例
<?php
  abstract class AbstractClass {
    // 强制要求子类定义这些方法
    abstract protected function getValue();
    abstract protected function prefixValue($prefix); 
    // 普通方法（非抽象方法）
    public function printOut() {
      print $this -> getValue() . "\n";
    } 
  } 

  class ConcreteClass1 extends AbstractClass {
    protected function getValue() {
      return "ConcreteClass1";
    } 

    public function prefixValue($prefix) {
      return "{$prefix}ConcreteClass1";
    } 
  } 

  class ConcreteClass2 extends AbstractClass {
    public function getValue() {
      return "ConcreteClass2";
    } 

    public function prefixValue($prefix) {
      return "{$prefix}ConcreteClass2";
    } 
  } 

  $class1 = new ConcreteClass1;
  $class1 -> printOut();
  echo $class1 -> prefixValue('FOO_') . "\n";

  $class2 = new ConcreteClass2;
  $class2 -> printOut();
  echo $class2 -> prefixValue('FOO_') . "\n";
?>



Example #2 抽象类示例
<?php
  abstract class AbstractClass {
    // 我们的抽象方法仅需要定义需要的参数
    abstract protected function prefixName($name);
  } 

  class ConcreteClass extends AbstractClass {
    // 我们的子类可以定义父类签名中不存在的可选参数
    public function prefixName($name, $separator = ".") {
      if ($name == "Pacman") {
        $prefix = "Mr";
      } elseif ($name == "Pacwoman") {
        $prefix = "Mrs";
      } else {
        $prefix = "";
      } 
      return "{$prefix}{$separator} {$name}";
    } 
  } 

  $class = new ConcreteClass;
  echo $class -> prefixName("Pacman"), "\n";
  echo $class -> prefixName("Pacwoman"), "\n";
?>





对象接口 ¶
使用接口（interface），可以指定某个类必须实现哪些方法，但不需要定义这些方法的具体内容。
接口是通过 interface 关键字来定义的，就像定义一个标准的类一样，但其中定义所有的方法都是空的。
接口中定义的所有方法都必须是公有，这是接口的特性。

Note:接口也可以继承，通过使用 extends 操作符。 

Example #1 接口示例
<?php 
  // 声明一个'iTemplate'接口
  interface iTemplate {
    public function setVariable($name, $var);
    public function getHtml($template);
  } 
  // 实现接口
  // 下面的写法是正确的
  class Template implements iTemplate {
    private $vars = array();

    public function setVariable($name, $var) {
      $this -> vars[$name] = $var;
    } 

    public function getHtml($template) {
      foreach($this -> vars as $name => $value) {
        $template = str_replace('{' . $name . '}', $value, $template);
      } 

      return $template;
    } 
  } 
  // 下面的写法是错误的，会报错，因为没有实现 getHtml()：
  // Fatal error: Class BadTemplate contains 1 abstract methods
  // and must therefore be declared abstract (iTemplate::getHtml)
  class BadTemplate implements iTemplate {
    private $vars = array();

    public function setVariable($name, $var) {
      $this -> vars[$name] = $var;
    } 
  }
?>


Example #2 可扩充的接口
<?php
  interface a {
    public function foo();
  } 

  interface b extends a {
    public function baz(Baz $baz);
  } 
  // 正确写法
  class c implements b {
    public function foo() {
    } 

    public function baz(Baz $baz) {
    } 
  } 
  // 错误写法会导致一个致命错误
  class d implements b {
    public function foo() {
    } 

    public function baz(Foo $foo) {
    } 
  } 
?>





Example #3 继承多个接口
<?php
  interface a {
    public function foo();
  } 

  interface b {
    public function bar();
  } 

  interface c extends a, b {
    public function baz();
  } 

  class d implements c {
    public function foo() {
    } 

    public function bar() {
    } 

    public function baz() {
    } 
  } 
?>


Example #4 使用接口常量
<?php
  interface a {
    const b = 'Interface constant';
  } 
  // 输出接口常量
  echo a :: b;
  // 错误写法，因为常量不能被覆盖。接口常量的概念和类常量是一样的。
  class b implements a {
    const b = 'Class constant';
  } 
?>



Trait ¶

自 PHP 5.4.0 起，PHP 实现了一种代码复用的方法，称为 trait。

Trait 是为类似 PHP 的单继承语言而准备的一种代码复用机制。Trait 为了减少单继承语言的限制，使开发人员能够自由地在不同层次结构内独立的类中复用 method。Trait 和 Class 组合的语义定义了一种减少复杂性的方式，避免传统多继承和 Mixin 类相关典型问题。

Trait 和 Class 相似，但仅仅旨在用细粒度和一致的方式来组合功能。 无法通过 trait 自身来实例化。它为传统继承增加了水平特性的组合；也就是说，应用的几个 Class 之间不需要继承。 



Example #1 Trait 示例
<?php
  trait ezcReflectionReturnInfo {
      function getReturnType() { /*1*/ }
      function getReturnDescription() { /*2*/ }
  }

  class ezcReflectionMethod extends ReflectionMethod {
      use ezcReflectionReturnInfo;
      /* ... */
  }

  class ezcReflectionFunction extends ReflectionFunction {
      use ezcReflectionReturnInfo;
      /* ... */
  }
?>



优先级
从基类继承的成员会被 trait 插入的成员所覆盖。优先顺序是来自当前类的成员覆盖了 trait 的方法，而 trait 则覆盖了被继承的方法。
Example #2 优先顺序示例

从基类继承的成员被插入的 SayWorld Trait 中的 MyHelloWorld 方法所覆盖。其行为 MyHelloWorld 类中定义的方法一致。优先顺序是当前类中的方法会覆盖 trait 方法，而 trait 方法又覆盖了基类中的方法。
<?php
  class Base {
      public function sayHello() {
          echo 'Hello ';
      }
  }

  trait SayWorld {
      public function sayHello() {
          parent::sayHello();
          echo 'World!';
      }
  }

  class MyHelloWorld extends Base {
      use SayWorld;
  }

  $o = new MyHelloWorld();
  $o->sayHello();
?>



Example #3 另一个优先级顺序的例子
<?php
  trait HelloWorld {
      public function sayHello() {
          echo 'Hello World!';
      }
  }

  class TheWorldIsNotEnough {
      use HelloWorld;
      public function sayHello() {
          echo 'Hello Universe!';
      }
  }

  $o = new TheWorldIsNotEnough();
  $o->sayHello();
?>


多个 trait 
通过逗号分隔，在 use 声明列出多个 trait，可以都插入到一个类中。
Example #4 多个 trait 的用法
<?php
  trait Hello {
      public function sayHello() {
          echo 'Hello ';
      }
  }

  trait World {
      public function sayWorld() {
          echo 'World';
      }
  }

  class MyHelloWorld {
      use Hello, World;
      public function sayExclamationMark() {
          echo '!';
      }
  }

  $o = new MyHelloWorld();
  $o->sayHello();
  $o->sayWorld();
  $o->sayExclamationMark();
?>


冲突的解决

如果两个 trait 都插入了一个同名的方法，如果没有明确解决冲突将会产生一个致命错误。
为了解决多个 trait 在同一个类中的命名冲突，需要使用 insteadof 操作符来明确指定使用冲突方法中的哪一个。
以上方式仅允许排除掉其它方法，as 操作符可以 为某个方法引入别名。 注意，as 操作符不会对方法进行重命名，也不会影响其方法。

Example #5 冲突的解决
在本例中 Talker 使用了 trait A 和 B。由于 A 和 B 有冲突的方法，其定义了使用 trait B 中的 smallTalk 以及 trait A 中的 bigTalk。
Aliased_Talker 使用了 as 操作符来定义了 talk 来作为 B 的 bigTalk 的别名。
<?php
  trait A {
      public function smallTalk() {
          echo 'a';
      }
      public function bigTalk() {
          echo 'A';
      }
  }

  trait B {
      public function smallTalk() {
          echo 'b';
      }
      public function bigTalk() {
          echo 'B';
      }
  }

  class Talker {
      use A, B {
          B::smallTalk insteadof A;
          A::bigTalk insteadof B;
      }
  }

  class Aliased_Talker {
      use A, B {
          B::smallTalk insteadof A;
          A::bigTalk insteadof B;
          B::bigTalk as talk;
      }
  }
?>



修改方法的访问控制
使用 as 语法还可以用来调整方法的访问控制。

Example #6 修改方法的访问控制
<?php
  trait HelloWorld {
      public function sayHello() {
          echo 'Hello World!';
      }
  }

  // 修改 sayHello 的访问控制
  class MyClass1 {
      use HelloWorld { sayHello as protected; }
  }

  // 给方法一个改变了访问控制的别名
  // 原版 sayHello 的访问控制则没有发生变化
  class MyClass2 {
      use HelloWorld { sayHello as private myPrivateHello; }
  }
?>


从 trait 来组成 trait
正如 class 能够使用 trait 一样，其它 trait 也能够使用 trait。在 trait 定义时通过使用一个或多个 trait，能够组合其它 trait 中的部分或全部成员。

Example #7 从 trait 来组成 trait
<?php
  trait Hello {
      public function sayHello() {
          echo 'Hello ';
      }
  }

  trait World {
      public function sayWorld() {
          echo 'World!';
      }
  }

  trait HelloWorld {
      use Hello, World;
  }

  class MyHelloWorld {
      use HelloWorld;
  }

  $o = new MyHelloWorld();
  $o->sayHello();
  $o->sayWorld();
?>



Trait 的抽象成员
为了对使用的类施加强制要求，trait 支持抽象方法的使用。

Example #8 表示通过抽象方法来进行强制要求
<?php
  trait Hello {
      public function sayHelloWorld() {
          echo 'Hello'.$this->getWorld();
      }
      abstract public function getWorld();
  }

  class MyHelloWorld {
      private $world;
      use Hello;
      public function getWorld() {
          return $this->world;
      }
      public function setWorld($val) {
          $this->world = $val;
      }
  }
?>


Trait 的静态成员
Traits 可以被静态成员静态方法定义。

Example #9 静态变量
<?php
  trait Counter {
      public function inc() {
          static $c = 0;
          $c = $c + 1;
          echo "$c\n";
      }
  }

  class C1 {
      use Counter;
  }

  class C2 {
      use Counter;
  }

  $o = new C1(); $o->inc(); // echo 1
  $p = new C2(); $p->inc(); // echo 1
?>


Example #10 静态方法
<?php
  trait StaticExample {
      public static function doSomething() {
          return 'Doing something';
      }
  }

  class Example {
      use StaticExample;
  }

  Example::doSomething();
?>


属性
Trait 同样可以定义属性。

Example #11 定义属性
<?php
  trait PropertiesTrait {
      public $x = 1;
  }

  class PropertiesExample {
      use PropertiesTrait;
  }

  $example = new PropertiesExample;
  $example->x;
?>


 Trait 定义了一个属性后，类就不能定义同样名称的属性，否则会产生 fatal error。 有种情况例外：属性是兼容的（同样的访问可见度、初始默认值）。 在 PHP 7.0 之前，属性是兼容的，则会有 E_STRICT 的提醒。

Example #12 解决冲突
<?php
  trait PropertiesTrait {
      public $same = true;
      public $different = false;
  }

  class PropertiesExample {
      use PropertiesTrait;
      public $same = true; // PHP 7.0.0 后没问题，之前版本是 E_STRICT 提醒
      public $different = true; // 致命错误
  }
?>


匿名类

PHP 7 开始支持匿名类。 匿名类很有用，可以创建一次性的简单对象。
<?php

  // PHP 7 之前的代码
  class Logger
  {
      public function log($msg)
      {
          echo $msg;
      }
  }

  $util->setLogger(new Logger());

  // 使用了 PHP 7+ 后的代码
  $util->setLogger(new class {
      public function log($msg)
      {
          echo $msg;
      }
  });
?>


可以传递参数到匿名类的构造器，也可以扩展（extend）其他类、实现接口（implement interface），以及像其他普通的类一样使用 trait：
<?php
  class SomeClass {}
  interface SomeInterface {}
  trait SomeTrait {}

  var_dump(new class(10) extends SomeClass implements SomeInterface {
      private $num;

      public function __construct($num)
      {
          $this->num = $num;
      }

      use SomeTrait;
  });
?>


 匿名类被嵌套进普通 Class 后，不能访问这个外部类（Outer class）的 private（私有）、protected（受保护）方法或者属性。 为了访问外部类（Outer class）protected 属性或方法，匿名类可以 extend（扩展）此外部类。 为了使用外部类（Outer class）的 private 属性，必须通过构造器传进来：
<?php
  class Outer {
    private $prop = 1;
    protected $prop2 = 2;

    protected function func1() {
      return 3;
    } 

    public function func2() {
      return new class($this -> prop) extends Outer {
        private $prop3;

        public function __construct($prop) {
          $this -> prop3 = $prop;
        } 

        public function func3() {
          return $this -> prop2 + $this -> prop3 + $this -> func1();
        } 
      } ;
    } 
  } 

  echo (new Outer) -> func2() -> func3();
?>
以上例程会输出：6


声明的同一个匿名类，所创建的对象都是这个类的实例。
<?php
  function anonymous_class() {
    return new class {
    } ;
  } 

  if (get_class(anonymous_class()) === get_class(anonymous_class())) {
    echo 'same class';
  } else {
    echo 'different class';
  } 
?>
以上例程会输出：same class


Note:注意，匿名类的名称是通过引擎赋予的，如下例所示。 由于实现的细节，不应该去依赖这个类名。
<?php
  echo get_class(new class {});
?>
以上例程的输出类似于：class@anonymous/in/oNi1A0x7f8636ad2021


重载
PHP所提供的"重载"（overloading）是指动态地"创建"类属性和方法。我们是通过魔术方法（magic methods）来实现的。
当调用当前环境下未定义或不可见的类属性或方法时，重载方法会被调用。本节后面将使用"不可访问属性（inaccessible properties）"和"不可访问方法（inaccessible methods）"来称呼这些未定义或不可见的类属性或方法。

所有的重载方法都必须被声明为 public。

Note:这些魔术方法的参数都不能通过引用传递。

Note:PHP中的"重载"与其它绝大多数面向对象语言不同。传统的"重载"是用于提供多个同名的类方法，但各方法的参数类型和个数不同。 


属性重载 ¶
public void __set ( string $name , mixed $value )
public mixed __get ( string $name )
public bool __isset ( string $name )
public void __unset ( string $name )

在给不可访问属性赋值时，__set() 会被调用。

读取不可访问属性的值时，__get() 会被调用。

当对不可访问属性调用 isset() 或 empty() 时，__isset() 会被调用。

当对不可访问属性调用 unset() 时，__unset() 会被调用。

参数 $name 是指要操作的变量名称。__set() 方法的 $value 参数指定了 $name 变量的值。

属性重载只能在对象中进行。在静态方法中，这些魔术方法将不会被调用。所以这些方法都不能被 声明为 static。从 PHP 5.3.0 起, 将这些魔术方法定义为 static 会产生一个警告。

Note: 因为 PHP 处理赋值运算的方式，__set() 的返回值将被忽略。类似的, 在下面这样的链式赋值中，__get() 不会被调用：
$a = $obj->b = 8; 

Note:在除 isset() 外的其它语言结构中无法使用重载的属性，这意味着当对一个重载的属性使用 empty() 时，重载魔术方法将不会被调用。
为避开此限制，必须将重载属性赋值到本地变量再使用 empty()。 


Example #1 使用 __get()，__set()，__isset() 和 __unset() 进行属性重载
<?php
  class PropertyTest {
    /**
     * *  被重载的数据保存在此
     */
    private $data = array();

    /**
     * *  重载不能被用在已经定义的属性
     */
    public $declared = 1;

    /**
     * *  只有从类外部访问这个属性时，重载才会发生
     */
    private $hidden = 2;

    public function __set($name, $value) {
      echo "Setting '$name' to '$value'\n";
      $this -> data[$name] = $value;
    } 

    public function __get($name) {
      echo "Getting '$name'\n";
      if (array_key_exists($name, $this -> data)) {
        return $this -> data[$name];
      } 

      $trace = debug_backtrace();
      trigger_error('Undefined property via __get(): ' . $name . ' in ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'],
        E_USER_NOTICE);
      return null;
    } 

    /**
     * *  PHP 5.1.0之后版本
     */
    public function __isset($name) {
      echo "Is '$name' set?\n";
      return isset($this -> data[$name]);
    } 

    /**
     * *  PHP 5.1.0之后版本
     */
    public function __unset($name) {
      echo "Unsetting '$name'\n";
      unset($this -> data[$name]);
    } 

    /**
     * *  非魔术方法
     */
    public function getHidden() {
      return $this -> hidden;
    } 
  } 

  echo "<pre>\n";

  $obj = new PropertyTest;

  $obj -> a = 1;
  echo $obj -> a . "\n\n";

  var_dump(isset($obj -> a));
  unset($obj -> a);
  var_dump(isset($obj -> a));
  echo "\n";

  echo $obj -> declared . "\n\n";

  echo "Let's experiment with the private property named 'hidden':\n";
  echo "Privates are visible inside the class, so __get() not used...\n";
  echo $obj -> getHidden() . "\n";
  echo "Privates not visible outside of class, so __get() is used...\n";
  echo $obj -> hidden . "\n";
?>


方法重载 ¶
public mixed __call ( string $name , array $arguments )
public static mixed __callStatic ( string $name , array $arguments )

在对象中调用一个不可访问方法时，__call() 会被调用。

在静态上下文中调用一个不可访问方法时，__callStatic() 会被调用。

$name 参数是要调用的方法名称。$arguments 参数是一个枚举数组，包含着要传递给方法 $name 的参数。 



Example #2 使用 __call() 和 __callStatic() 对方法重载
<?php
  class MethodTest {
    public function __call($name, $arguments) {
      // 注意: $name 的值区分大小写
      echo "Calling object method '$name' "
       . implode(', ', $arguments) . "\n";
    } 

    /**
     * *  PHP 5.3.0之后版本
     */
    public static function __callStatic($name, $arguments) {
      // 注意: $name 的值区分大小写
      echo "Calling static method '$name' "
       . implode(', ', $arguments) . "\n";
    } 
  } 

  $obj = new MethodTest;
  $obj -> runTest('in object context');

  MethodTest :: runTest('in static context'); // PHP 5.3.0之后版本
?>

以上例程会输出：
Calling object method 'runTest' in object context
Calling static method 'runTest' in static context


遍历对象 ¶
PHP 5 提供了一种定义对象的方法使其可以通过单元列表来遍历，例如用 foreach 语句。默认情况下，所有可见属性都将被用于遍历。
Example #1 简单的对象遍历
<?php
  class MyClass {
    public $var1 = 'value 1';
    public $var2 = 'value 2';
    public $var3 = 'value 3';

    protected $protected = 'protected var';
    private $private = 'private var';

    function iterateVisible() {
      echo "MyClass::iterateVisible:\n";
      foreach($this as $key => $value) {
        print "$key => $value\n";
      } 
    } 
  } 

  $class = new MyClass();

  foreach($class as $key => $value) {
    print "$key => $value\n";
  } 
  echo "\n";

  $class -> iterateVisible();
?>
如上所示，foreach 遍历了所有其能够访问的可见属性


更进一步，可以实现 Iterator 接口。可以让对象自行决定如何遍历以及每次遍历时那些值可用。

Example #2 实现 Iterator 接口的对象遍历
<?php
  class MyIterator implements Iterator {
    private $var = array();

    public function __construct($array) {
      if (is_array($array)) {
        $this -> var = $array;
      } 
    } 

    public function rewind() {
      echo "rewinding\n";
      reset($this -> var);
    } 

    public function current() {
      $var = current($this -> var);
      echo "current: $var\n";
      return $var;
    } 

    public function key() {
      $var = key($this -> var);
      echo "key: $var\n";
      return $var;
    } 

    public function next() {
      $var = next($this -> var);
      echo "next: $var\n";
      return $var;
    } 

    public function valid() {
      $var = $this -> current() !== false;
      echo "valid: {$var}\n";
      return $var;
    } 
  } 

  $values = array(1, 2, 3);
  $it = new MyIterator($values);

  foreach ($it as $a => $b) {
    print "$a: $b\n";
  } 

?>


可以用 IteratorAggregate 接口以替代实现所有的 Iterator 方法。IteratorAggregate 只需要实现一个方法 IteratorAggregate::getIterator()，其应返回一个实现了 Iterator 的类的实例。

Example #3 通过实现 IteratorAggregate 来遍历对象
<?php
  class MyCollection implements IteratorAggregate {
    private $items = array();
    private $count = 0; 
    // Required definition of interface IteratorAggregate
    public function getIterator() {
      return new MyIterator($this -> items);
    } 

    public function add($value) {
      $this -> items[$this -> count++] = $value;
    } 
  } 

  $coll = new MyCollection();
  $coll -> add('value 1');
  $coll -> add('value 2');
  $coll -> add('value 3');

  foreach ($coll as $key => $val) {
    echo "key/value: [$key -> $val]\n\n";
  } 
?>

Note:PHP 5.5 及以后版本的用户也可参考生成器，其提供了另一方法来定义 Iterators。 



魔术方法 ¶

__construct()， __destruct()， __call()， __callStatic()， __get()， __set()， __isset()， __unset()， __sleep()， __wakeup()， __toString()， __invoke()， __set_state()， __clone() 和 __debugInfo() 等方法在 PHP 中被称为"魔术方法"（Magic methods）。在命名自己的类方法时不能使用这些方法名，除非是想使用其魔术功能。
Caution

PHP 将所有以 __（两个下划线）开头的类方法保留为魔术方法。所以在定义类方法时，除了上述魔术方法，建议不要以 __ 为前缀。


 __sleep() 和 __wakeup() ¶
public array __sleep ( void )
void __wakeup ( void )

serialize() 函数会检查类中是否存在一个魔术方法 __sleep()。如果存在，该方法会先被调用，然后才执行序列化操作。此功能可以用于清理对象，并返回一个包含对象中所有应被序列化的变量名称的数组。如果该方法未返回任何内容，则 NULL 被序列化，并产生一个 E_NOTICE 级别的错误。 


Note:__sleep() 不能返回父类的私有成员的名字。这样做会产生一个 E_NOTICE 级别的错误。可以用 Serializable 接口来替代。 

 __sleep() 方法常用于提交未提交的数据，或类似的清理操作。同时，如果有一些很大的对象，但不需要全部保存，这个功能就很好用。

与之相反，unserialize() 会检查是否存在一个 __wakeup() 方法。如果存在，则会先调用 __wakeup 方法，预先准备对象需要的资源。

__wakeup() 经常用在反序列化操作中，例如重新建立数据库连接，或执行其它初始化操作。 


Example #1 Sleep 和 wakeup
<?php
class Connection {
  protected $link;
  private $server, $username, $password, $db;

  public function __construct($server, $username, $password, $db) {
    $this -> server = $server;
    $this -> username = $username;
    $this -> password = $password;
    $this -> db = $db;
    $this -> connect();
  } 

  private function connect() {
    $this -> link = mysql_connect($this -> server, $this -> username, $this -> password);
    mysql_select_db($this -> db, $this -> link);
  } 

  public function __sleep() {
    return array('server', 'username', 'password', 'db');
  } 

  public function __wakeup() {
    $this -> connect();
  } 
} 
?>


__toString() ¶
public string __toString ( void )

__toString() 方法用于一个类被当成字符串时应怎样回应。例如 echo $obj; 应该显示些什么。此方法必须返回一个字符串，否则将发出一条 E_RECOVERABLE_ERROR 级别的致命错误。
Warning：不能在 __toString() 方法中抛出异常。这么做会导致致命错误。

Example #2 简单示例
<?php 
  // Declare a simple class
  class TestClass {
    public $foo;

    public function __construct($foo) {
      $this -> foo = $foo;
    } 

    public function __toString() {
      return $this -> foo;
    } 
  } 

  $class = new TestClass('Hello');
  echo $class;
?>

需要指出的是在 PHP 5.2.0 之前，__toString() 方法只有在直接使用于 echo 或 print 时才能生效。PHP 5.2.0 之后，则可以在任何字符串环境生效（例如通过 printf()，使用 %s 修饰符），但不能用于非字符串环境（如使用 %d 修饰符）。自 PHP 5.2.0 起，如果将一个未定义 __toString() 方法的对象转换为字符串，会产生 E_RECOVERABLE_ERROR 级别的错误。 


__invoke() ¶
mixed __invoke ([ $... ] )

当尝试以调用函数的方式调用一个对象时，__invoke() 方法会被自动调用。

Note:本特性只在 PHP 5.3.0 及以上版本有效。

Example #3 使用 __invoke()
<?php
  class CallableClass {
    function __invoke($x) {
      var_dump($x);
    } 
  } 
  $obj = new CallableClass;
  $obj(5);
  var_dump(is_callable($obj));
?>


__set_state() ¶
static object __set_state ( array $properties )

自 PHP 5.1.0 起当调用 var_export() 导出类时，此静态 方法会被调用。

本方法的唯一参数是一个数组，其中包含按 array('property' => value, ...) 格式排列的类属性。

Example #4 使用 __set_state()>（PHP 5.1.0 起）
<?php
  class A {
    public $var1;
    public $var2;

    public static function __set_state($an_array) { // As of PHP 5.1.0
      $obj = new A;
      $obj -> var1 = $an_array['var1'];
      $obj -> var2 = $an_array['var2'];
      return $obj;
    } 
  } 

  $a = new A;
  $a -> var1 = 5;
  $a -> var2 = 'foo';

  eval('$b = ' . var_export($a, true) . ';'); // $b = A::__set_state(array( 
  // 'var1' => 5,
  // 'var2' => 'foo',
  // ));
  var_dump($b);
?>


__debugInfo() ¶
array __debugInfo ( void )

当转储对象以获取应显示的属性时，此方法由var_dump（）调用。 如果在对象上定义了该方法，那么将显示所有public，protected和private属性。

This feature was added in PHP 5.6.0.

Example #5 Using __debugInfo()
<?php
  class C {
    private $prop;

    public function __construct($val) {
      $this -> prop = $val;
    } 

    public function __debugInfo() {
      return [
      'propSquared' => $this -> prop * * 2,
      ];
    } 
  } 

  var_dump(new C(42));
?>



Final 关键字 ¶

PHP 5 新增了一个 final 关键字。如果父类中的方法被声明为 final，则子类无法覆盖该方法。如果一个类被声明为 final，则不能被继承。
Example #1 Final 方法示例
<?php
  class BaseClass {
     public function test() {
         echo "BaseClass::test() called\n";
     }
     
     final public function moreTesting() {
         echo "BaseClass::moreTesting() called\n";
     }
  }

  class ChildClass extends BaseClass {
     public function moreTesting() {
         echo "ChildClass::moreTesting() called\n";
     }
  }
  // Results in Fatal error: Cannot override final method BaseClass::moreTesting()
?>





Example #2 Final 类示例
<?php
  final class BaseClass {
     public function test() {
         echo "BaseClass::test() called\n";
     }
     
     // 这里无论你是否将方法声明为final，都没有关系
     final public function moreTesting() {
         echo "BaseClass::moreTesting() called\n";
     }
  }

  class ChildClass extends BaseClass {
  }
  // 产生 Fatal error: Class ChildClass may not inherit from final class (BaseClass)
?>

Note: 属性不能被定义为 final，只有类和方法才能被定义为 final。 


对象复制 ¶

在多数情况下，我们并不需要完全复制一个对象来获得其中属性。但有一个情况下确实需要：如果你有一个 GTK 窗口对象，该对象持有窗口相关的资源。你可能会想复制一个新的窗口，保持所有属性与原来的窗口相同，但必须是一个新的对象（因为如果不是新的对象，那么一个窗口中的改变就会影响到另一个窗口）。还有一种情况：如果对象 A 中保存着对象 B 的引用，当你复制对象 A 时，你想其中使用的对象不再是对象 B 而是 B 的一个副本，那么你必须得到对象 A 的一个副本。

对象复制可以通过 clone 关键字来完成（如果可能，这将调用对象的 __clone() 方法）。对象中的 __clone() 方法不能被直接调用。

$copy_of_object = clone $object;

当对象被复制后，PHP 5 会对对象的所有属性执行一个浅复制（shallow copy）。所有的引用属性 仍然会是一个指向原来的变量的引用。
void __clone ( void )

当复制完成时，如果定义了 __clone() 方法，则新创建的对象（复制生成的对象）中的 __clone() 方法会被调用，可用于修改属性的值（如果有必要的话）。 
Example #1 复制一个对象
<?php
  class SubObject {
    static $instances = 0;
    public $instance;

    public function __construct() {
      $this -> instance = ++self :: $instances;
    } 

    public function __clone() {
      $this -> instance = ++self :: $instances;
    } 
  } 

  class MyCloneable {
    public $object1;
    public $object2;

    function __clone() {
      // 强制复制一份this->object， 否则仍然指向同一个对象
      $this -> object1 = clone $this -> object1;
    } 
  } 

  $obj = new MyCloneable();

  $obj -> object1 = new SubObject();
  $obj -> object2 = new SubObject();

  $obj2 = clone $obj;

  print("Original Object:\n");
  print_r($obj);

  print("Cloned Object:\n");
  print_r($obj2);
?>


对象比较 ¶

PHP 5 中的对象比较要比 PHP 4 中复杂，所期望的结果更符合一个面向对象语言。

当使用比较运算符（==）比较两个对象变量时，比较的原则是：如果两个对象的属性和属性值 都相等，而且两个对象是同一个类的实例，那么这两个对象变量相等。

而如果使用全等运算符（===），这两个对象变量一定要指向某个类的同一个实例（即同一个对象）。

通过下面的示例可以理解以上原则。

Example #1 PHP 5 的对象比较
<?php
  function bool2str($bool) {
    if ($bool === false) {
      return 'FALSE';
    } else {
      return 'TRUE';
    } 
  } 

  function compareObjects(&$o1, &$o2) {
    echo 'o1 == o2 : ' . bool2str($o1 == $o2) . "\n";
    echo 'o1 != o2 : ' . bool2str($o1 != $o2) . "\n";
    echo 'o1 === o2 : ' . bool2str($o1 === $o2) . "\n";
    echo 'o1 !== o2 : ' . bool2str($o1 !== $o2) . "\n";
  } 

  class Flag {
    public $flag;

    function Flag($flag = true) {
      $this -> flag = $flag;
    } 
  } 

  class OtherFlag {
    public $flag;

    function OtherFlag($flag = true) {
      $this -> flag = $flag;
    } 
  } 

  $o = new Flag();
  $p = new Flag();
  $q = $o;
  $r = new OtherFlag();

  echo "Two instances of the same class\n";
  compareObjects($o, $p);

  echo "\nTwo references to the same instance\n";
  compareObjects($o, $q);

  echo "\nInstances of two different classes\n";
  compareObjects($o, $r);
?>


类型约束 ¶
PHP 5 可以使用类型约束。函数的参数可以指定必须为对象（在函数原型里面指定类的名字），接口，数组（PHP 5.1 起）或者 callable（PHP 5.4 起）。不过如果使用 NULL 作为参数的默认值，那么在调用函数的时候依然可以使用 NULL 作为实参。

如果一个类或接口指定了类型约束，则其所有的子类或实现也都如此。

类型约束不能用于标量类型如 int 或 string。Traits 也不允许。
Example #1 类型约束示例
<?php 
  // 如下面的类
  class MyClass {
    /**
     * 测试函数
     * 第一个参数必须为 OtherClass 类的一个对象
     */
    public function test(OtherClass $otherclass) {
      echo $otherclass -> var;
    } 

    /**
     * 另一个测试函数
  第一个参数必须为数组
     */
    public function test_array(array $input_array) {
      print_r($input_array);
    } 
  } 

  /**
   * 第一个参数必须为递归类型
   */
  public function test_interface(Traversable $iterator) {
    echo get_class($iterator);
  } 

  /**
   * 第一个参数必须为回调类型
   */
  public function test_callable(callable $callback, $data) {
    call_user_func($callback, $data);
  } 
  } 
  // OtherClass 类定义
  class OtherClass {
  public $var = 'Hello World';
  } 
?>

函数调用的参数与定义的参数类型不一致时，会抛出一个可捕获的致命错误。

<?php
  // 两个类的对象
  $myclass = new MyClass;
  $otherclass = new OtherClass;

  // 致命错误：第一个参数必须是 OtherClass 类的一个对象
  $myclass->test('hello');

  // 致命错误：第一个参数必须为 OtherClass 类的一个实例
  $foo = new stdClass;
  $myclass->test($foo);

  // 致命错误：第一个参数不能为 null
  $myclass->test(null);

  // 正确：输出 Hello World 
  $myclass->test($otherclass);

  // 致命错误：第一个参数必须为数组
  $myclass->test_array('a string');

  // 正确：输出数组
  $myclass->test_array(array('a', 'b', 'c'));

  // 正确：输出 ArrayObject
  $myclass->test_interface(new ArrayObject(array()));

  // 正确：输出 int(1)
  $myclass->test_callable('var_dump', 1);
?>


类型约束不只是用在类的成员函数里，也能使用在函数里：
<?php
  // 如下面的类
  class MyClass {
      public $var = 'Hello World';
  }

  /**
   * 测试函数
   * 第一个参数必须是 MyClass 类的一个对象
   */
  function MyFunction (MyClass $foo) {
      echo $foo->var;
  }

  // 正确
  $myclass = new MyClass;
  MyFunction($myclass);
?>


类型约束允许 NULL 值：
<?php
  /* 接受 NULL 值 */
  function test(stdClass $obj = NULL) {

  }

  test(NULL);
  test(new stdClass);
?>


后期静态绑定 ¶

自 PHP 5.3.0 起，PHP 增加了一个叫做后期静态绑定的功能，用于在继承范围内引用静态调用的类。

准确说，后期静态绑定工作原理是存储了在上一个“非转发调用”（non-forwarding call）的类名。当进行静态方法调用时，该类名即为明确指定的那个（通常在 :: 运算符左侧部分）；当进行非静态方法调用时，即为该对象所属的类。所谓的“转发调用”（forwarding call）指的是通过以下几种方式进行的静态调用：self::，parent::，static:: 以及 forward_static_call()。可用 get_called_class() 函数来得到被调用的方法所在的类名，static:: 则指出了其范围。

该功能从语言内部角度考虑被命名为“后期静态绑定”。“后期绑定”的意思是说，static:: 不再被解析为定义当前方法所在的类，而是在实际运行时计算的。也可以称之为“静态绑定”，因为它可以用于（但不限于）静态方法的调用。 

self:: 的限制 ¶

使用 self:: 或者 __CLASS__ 对当前类的静态引用，取决于定义当前方法所在的类：

Example #1 self:: 用法
<?php
  class A {
      public static function who() {
          echo __LINE__;
      }
      public static function test() {
          self::who();
      }
  }

  class B extends A {
      public static function who() {
          echo 'good';
      }
  }

  B::test();
?>


后期静态绑定的用法 ¶

后期静态绑定本想通过引入一个新的关键字表示运行时最初调用的类来绕过限制。简单地说，这个关键字能够让你在上述例子中调用 test() 时引用的类是 B 而不是 A。最终决定不引入新的关键字，而是使用已经预留的 static 关键字。

Example #2 static:: 简单用法
<?php
  class A {
    public static function who() {
      echo __CLASS__;
    } 
    public static function test() {
      static :: who(); // 后期静态绑定从这里开始
    } 
  } 

  class B extends A {
    public static function who() {
      echo __CLASS__;
    } 
  } 

  B :: test();
?>

Note:在非静态环境下，所调用的类即为该对象实例所属的类。由于 $this-> 会在同一作用范围内尝试调用私有方法，而 static:: 则可能给出不同结果。另一个区别是 static:: 只能用于静态属性。 

Example #3 非静态环境下使用 static::

<?php
  class A {
      private function foo() {
          echo "success!\n";
      }
      public function test() {
          $this->foo();
          static::foo();
      }
  }

  class B extends A {
     /* foo() will be copied to B, hence its scope will still be A and
      * the call be successful */
  }

  class C extends A {
      private function foo() {
          /* original method is replaced; the scope of the new one is C */
      }
  }

  $b = new B();
  $b->test();
  $c = new C();
  $c->test();   //fails
?>


Note:后期静态绑定的解析会一直到取得一个完全解析了的静态调用为止。另一方面，如果静态调用使用 parent:: 或者 self:: 将转发调用信息。 
Example #4 转发和非转发调用
<?php
  class A {
    public static function foo() {
      static :: who();
    } 

    public static function who() {
      echo __CLASS__ . "\n";
    } 
  } 

  class B extends A {
    public static function test() {
      A :: foo();
      parent :: foo();
      self :: foo();
    } 

    public static function who() {
      echo __CLASS__ . "\n";
    } 
  } 
  class C extends B {
    public static function who() {
      echo __CLASS__ . "\n";
    } 
  } 

  C :: test();
?>


对象和引用 ¶

在php5 的对象编程经常提到的一个关键点是“默认情况下对象是通过引用传递的”。但其实这不是完全正确的。下面通过一些例子来说明。

PHP 的引用是别名，就是两个不同的变量名字指向相同的内容。在 PHP 5，一个对象变量已经不再保存整个对象的值。只是保存一个标识符来访问真正的对象内容。 当对象作为参数传递，作为结果返回，或者赋值给另外一个变量，另外一个变量跟原来的不是引用的关系，只是他们都保存着同一个标识符的拷贝，这个标识符指向同一个对象的真正内容。

Example #1 引用和对象
<?php
  class A {
      public $foo = 1;
  }  

  $a = new A;
  $b = $a;     // $a ,$b都是同一个标识符的拷贝
               // ($a) = ($b) = <id>
  $b->foo = 2;
  echo $a->foo."\n";


  $c = new A;
  $d = &$c;    // $c ,$d是引用
               // ($c,$d) = <id>

  $d->foo = 2;
  echo $c->foo."\n";


  $e = new A;

  function foo($obj) {
      // ($obj) = ($e) = <id>
      $obj->foo = 2;
  }

  foo($e);
  echo $e->foo."\n";
?>


对象序列化 ¶
序列化对象 - 在会话中存放对象 ¶

所有php里面的值都可以使用函数serialize()来返回一个包含字节流的字符串来表示。unserialize()函数能够重新把字符串变回php原来的值。 序列化一个对象将会保存对象的所有变量，但是不会保存对象的方法，只会保存类的名字。

为了能够unserialize()一个对象，这个对象的类必须已经定义过。如果序列化类A的一个对象，将会返回一个跟类A相关，而且包含了对象所有变量值的字符串。 如果要想在另外一个文件中解序列化一个对象，这个对象的类必须在解序列化之前定义，可以通过包含一个定义该类的文件或使用函数spl_autoload_register()来实现。 

<?php
// classa.inc:
  
  class A {
      public $one = 1;
    
      public function show_one() {
          echo $this->one;
      }
  }
  
// page1.php:

  include("classa.inc");
  
  $a = new A;
  $s = serialize($a);
  // 把变量$s保存起来以便文件page2.php能够读到
  file_put_contents('store', $s);

// page2.php:
  
  // 要正确了解序列化，必须包含下面一个文件
  include("classa.inc");

  $s = file_get_contents('store');
  $a = unserialize($s);

  // 现在可以使用对象$a里面的函数 show_one()
  $a->show_one();
?>


 当一个应用程序使用函数session_register()来保存对象到会话中时，在每个页面结束的时候这些对象都会自动序列化，而在每个页面开始的时候又自动解序列化。 所以一旦对象被保存在会话中，整个应用程序的页面都能使用这些对象。但是，session_register()在php5.4.0之后被移除了。

在应用程序中序列化对象以便在之后使用，强烈推荐在整个应用程序都包含对象的类的定义。 不然有可能出现在解序列化对象的时候，没有找到该对象的类的定义，从而把没有方法的类__PHP_Incomplete_Class_Name作为该对象的类，导致返回一个没有用的对象。

所以在上面的例子中，当运行session_register("a")，把变量$a放在会话里之后，需要在每个页面都包含文件classa.inc，而不是只有文件page1.php和page2.php。

除了以上建议，可以在对象上使用 __sleep() 和 __wakeup() 方法对序列化/反序列化事件挂载钩子。 使用 __sleep() 也能够让仅仅序列化对象的某些属性。 


OOP 变更日志 ¶

PHP 5 OOP 模型的变更将被记录在此。功能的描述与其他相关注意事项记录在了 OOP 5 文档之中。

版本  说明
7.0.0   Trait 里定义兼容的属性不再产生错误信息。
5.6.0   增加: __debugInfo() 方法。
5.5.0   增加: ::class 魔法常量。
5.5.0   增加: finally 来处理异常。
5.4.0   增加： traits。
5.4.0   已变更：如果一个抽象 类定义了构造函数的签名，它将必须被实现。
5.3.3   已变更： 命名空间 中和类同名的方法不再被作为 构造函数。这个变更不影响非命名空间中的类。
5.3.0   已变更：类实现接口的方法所具有的默认值不再需要和接口的默认值一致。
5.3.0   已变更： 现在它也能够通过一个变量来引用一个类（例如，echo $classname::constant;）。 这个变量的值不能是一个保留关键词（比如，self、parent 或 static）。
5.3.0   已变更： 如果重载方法被定义为 static 将导致一个 E_WARNING 级别的错误。 同时它也需要强制使用 public 的可见性。
5.3.0   已变更： 在 5.3.0 之前的版本，__autoload() 函数里抛出的异常不能被 catch 块结构捕获，并会导致一个致命错误。 现在在一个前提下 catch 块能够捕获 __autoload 函数中抛出的错误。如果抛出一个自定义异常，这个自定义异常的类必须是可用的。否则 __autoload 函数可能递归自动加载这个自定义异常类。
5.3.0   新增： __callStatic 方法。
5.3.0   新增： heredoc 和 nowdoc 支持类的 常量 和属性的定义。 注意：heredoc 值必须和双引号字符串遵循同样的规则（比如，变量将被替换）。
5.3.0   新增： 后期静态绑定。
5.3.0   新增： __invoke 方法。
5.2.0   已变更：__toString 方法仅在直接与 echo 或 print 使用时被调用。但是现在它能在任何字符串上下文被调用（比如在 printf() 中使用 %s ），但不是在其他类型的上下文被调用（例如 %d 修饰符）。 自 PHP 5.2.0 起，将不具有 __toString 方法的对象转化为字符串将导致一个 E_RECOVERABLE_ERROR 级别的错误。
5.1.3   已变更：在 PHP 5 之前的版本，var 的使用已被废弃，并将产生一个 E_STRICT 级别的错误。现在它不再被废弃，因此也不会产生错误。
5.1.0   已变更：现在 __set_state 静态方法在 var_export() 导出类时会被调用。
5.1.0   新增：__isset 和 __unset 方法。 

-------------类Class--end<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<


PHP htmlspecialchars和htmlspecialchars_decode(函数)是与mysql数据库转义还换用
<?php
  $str='&lt;p&gt;king&lt;/p&gt;&lt;br /&gt;';
  echo htmlspecialchars_decode($str);

  $str2='<p>king</p><br />';
  echo htmlspecialchars($str2);
?>


命名空间概述 ¶

(PHP 5 >= 5.3.0, PHP 7)

什么是命名空间？从广义上来说，命名空间是一种封装事物的方法。在很多地方都可以见到这种抽象概念。例如，在操作系统中目录用来将相关文件分组，对于目录中的文件来说，它就扮演了命名空间的角色。具体举个例子，文件 foo.txt 可以同时在目录/home/greg 和 /home/other 中存在，但在同一个目录中不能存在两个 foo.txt 文件。另外，在目录 /home/greg 外访问 foo.txt 文件时，我们必须将目录名以及目录分隔符放在文件名之前得到 /home/greg/foo.txt。这个原理应用到程序设计领域就是命名空间的概念。

在PHP中，命名空间用来解决在编写类库或应用程序时创建可重用的代码如类或函数时碰到的两类问题：

    用户编写的代码与PHP内部的类/函数/常量或第三方类/函数/常量之间的名字冲突。
    为很长的标识符名称(通常是为了缓解第一类问题而定义的)创建一个别名（或简短）的名称，提高源代码的可读性



定义命名空间 ¶

(PHP 5 >= 5.3.0, PHP 7)
虽然任意合法的PHP代码都可以包含在命名空间中，但只有以下类型的代码受命名空间的影响，它们是：类（包括抽象类和traits）、接口、函数和常量。

命名空间通过关键字namespace 来声明。如果一个文件中包含命名空间，它必须在其它所有代码之前声明命名空间，除了一个以外：declare关键字。

Example #1 声明单个命名空间
<?php
  namespace MyProject;

  const CONNECT_OK = 1;
  class Connection { /* ... */ }
  function connect() { /* ... */  }

?>



Example #2 声明单个命名空间
<html>
<?php
  namespace MyProject; // 致命错误 -　命名空间必须是程序脚本的第一条语句
?>

另外，与PHP其它的语言特征不同，同一个命名空间可以定义在多个文件中，即允许将同一个命名空间的内容分割存放在不同的文件中。


定义子命名空间 ¶
(PHP 5 >= 5.3.0, PHP 7)
与目录和文件的关系很象，PHP 命名空间也允许指定层次化的命名空间的名称。因此，命名空间的名字可以使用分层次的方式定义：

Example #1 声明分层次的单个命名空间
<?php
  namespace MyProject\Sub\Level;

  const CONNECT_OK = 1;
  class Connection { /* ... */ }
  function connect() { /* ... */  }

?>
上面的例子创建了常量MyProject\Sub\Level\CONNECT_OK，类 MyProject\Sub\Level\Connection和函数 MyProject\Sub\Level\connect。



在同一个文件中定义多个命名空间 ¶
(PHP 5 >= 5.3.0, PHP 7)
也可以在同一个文件中定义多个命名空间。在同一个文件中定义多个命名空间有两种语法形式。

Example #1 定义多个命名空间，简单组合语法
<?php
  namespace MyProject;

  const CONNECT_OK = 1;
  class Connection { /* ... */ }
  function connect() { /* ... */  }

  namespace AnotherProject;

  const CONNECT_OK = 1;
  class Connection { /* ... */ }
  function connect() { /* ... */  }
?>

不建议使用这种语法在单个文件中定义多个命名空间。建议使用下面的大括号形式的语法。

Example #2 定义多个命名空间，大括号语法
<?php
  namespace MyProject {

  const CONNECT_OK = 1;
  class Connection { /* ... */ }
  function connect() { /* ... */  }
  }

  namespace AnotherProject {

  const CONNECT_OK = 1;
  class Connection { /* ... */ }
  function connect() { /* ... */  }
}
?>

在实际的编程实践中，非常不提倡在同一个文件中定义多个命名空间。这种方式的主要用于将多个 PHP 脚本合并在同一个文件中。   

 将全局的非命名空间中的代码与命名空间中的代码组合在一起，只能使用大括号形式的语法。全局代码必须用一个不带名称的 namespace 语句加上大括号括起来，例如：
Example #3 定义多个命名空间和不包含在命名空间中的代码
<?php
  namespace MyProject {

  const CONNECT_OK = 1;
  class Connection { /* ... */ }
  function connect() { /* ... */  }
  }

  namespace { // global code
  session_start();
  $a = MyProject\connect();
  echo MyProject\Connection::start();
  }
?>

除了开始的declare语句外，命名空间的括号外不得有任何PHP代码。
Example #4 定义多个命名空间和不包含在命名空间中的代码
<?php
  declare(encoding='UTF-8');
  namespace MyProject {
    const CONNECT_OK = 1;
    class Connection { /* ... */ }
    function connect() { /* ... */  }
  }

  namespace { // 全局代码
    session_start();
    $a = MyProject\connect();
    echo MyProject\Connection::start();
  }
?>



引用是什么 ¶
在 PHP 中引用意味着用不同的名字访问同一个变量内容。这并不像 C 的指针：例如你不能对他们做指针运算，他们并不是实际的内存地址…… 查看引用不是什么了解更多信息。 替代的是，引用是符号表别名。注意在PHP 中，变量名和变量内容是不一样的， 因此同样的内容可以有不同的名字。最接近的比喻是 Unix 的文件名和文件本身——变量名是目录条目，而变量内容则是文件本身。引用可以被看作是 Unix 文件系统中的硬链接。



引用做什么 ¶
PHP 的引用允许用两个变量来指向同一个内容。意思是，当这样做时：
<?php
  $a =& $b;
?>
这意味着 $a 和 $b 指向了同一个变量。

Note:$a 和 $b 在这里是完全相同的，这并不是 $a 指向了 $b 或者相反，而是 $a 和 $b 指向了同一个地方。 
Note:如果具有引用的数组被拷贝，其值不会解除引用。对于数组传值给函数也是如此。
Note:如果对一个未定义的变量进行引用赋值、引用参数传递或引用返回，则会自动创建该变量。 



超全局变量 — 超全局变量是在全部作用域中始终可用的内置变量
$GLOBALS — 引用全局作用域中可用的全部变量
$_SERVER — 服务器和执行环境信息
$_GET — HTTP GET 变量
$_POST — HTTP POST 变量
$_FILES — HTTP 文件上传变量
$_REQUEST — HTTP Request 变量
$_SESSION — Session 变量
$_ENV — 环境变量
$_COOKIE — HTTP Cookies
$php_errormsg — 前一个错误信息
$HTTP_RAW_POST_DATA — 原生POST数据
$http_response_header — HTTP 响应头
$argc — 传递给脚本的参数数目
$argv — 传递给脚本的参数数组



Example #1 $GLOBALS 范例
<?php
  function test() {
      $foo = "local variable";

      echo '$foo in global scope: ' . $GLOBALS["foo"] . "\n";
      echo '$foo in current scope: ' . $foo . "\n";
  }

  $foo = "Example content";
  test();
?>



Example #1 $php_errormsg 范例
<?php
  @$arr=array(7,king);
  echo $php_errormsg;
?>


final可以修饰类，方法
static可以修饰属性，方法
const修饰的成员属性为常量，只能修饰成员属性



单例（单态，单件）设计模式————最适合php使用，ps：连接数据库
1.如果让一个类只能有一个对象，就让这个类不能创建对象，将构造方法设为private
2.可以在类中便用一个静态方法来创建对象
<?php
   class Person{
    public static $obj=null;

    private function __construct(){
      echo 'The Class is strar.<br>';
    }

    public static function setPerson(){
      if(is_null(self::$obj)){
        self::$obj=new Person;
        return self::$obj;
      }
      
      return self::$obj;
    }

    public function __destruct(){
      echo "The Class close<br>";
    }
   }

  $a=Person::setPerson();
  $a=Person::setPerson();
  $a=Person::setPerson();
  $a=Person::setPerson();
?>

类支持动态设置属性
<?php
	class Person{
		
	}
	$obj=new Person();
	$obj->bbc='bbcname';
	echo $obj->bbc;
?>

static静态方法是以类作为作用域的函数。静态方法不能访问这个类中的普通属性，因为那些属性属于一个对象，但可以访问静态属性。如果修改了一个静态属性，那么这个类的所有实例都能访问到这个新值。


self指向当前类
parent指向父类
$this指向当前对象


根据定义，我们不能在对象中调用静态方法，因此静态方法和属性又被称为类变量和属性，因此不能在静态方法中使用伪变量$this

类常量属性只包含基本数据类型的值，不能将一个对象指派给常量。像静态属性一样，只能通过类而不能通过类的实例访问常量。引用常量时不需要美元符号作为前符。

final关键字可以终止类的继承。final类不能有子类，final方法不能被覆写。

魔术方法
__get($property)    访问未定义的属性时被调用
__set($property)    给未定义的属性赋值时被调用
__isset($property)  对未定义的属性调用isset()时被用
__unset($property)  对未定义的属性调用unset()时被用
__cal($method,$arg_array)   调用未定义的方法时被调用


__get的经典用法：
<?php
    class Person{
        public function __get($property){
            $method = "get{$property}";

            if(method_exists($this,$method)){
                return $this->$method();    
            }
        }

        public function getName(){
            return 'king';
        }

        public function getAge(){
            return 26;
        }
    }


    $obj=new Person();
    echo $obj->name;
?>


__set($property)的经典用法
 <?php
    class Person{
        private $name;
        private $age;

        public function __set($property,$value){
            $method="set{$property}";
            if(method_exists($this,$method)){
                return $this->$method($value);
            }
        }

        function setName($name){
            $this->name=$name;

            if(!is_null($name)){
                $this->name=strtoupper($this->name);
            }
        }

        public function getAge($age){
            $this->age=$strtoupper($age);
        }

        public function getname(){
            echo $this->name;
        }
    }
    
    $obj=new Person();
    $obj->name='kingboy';

    $obj->getname();
?>


is_callable

(PHP 4 >= 4.0.6, PHP 5, PHP 7)
is_callable — 检测参数是否为合法的可调用结构

说明

bool is_callable ( callable $name [, bool $syntax_only = false [, string &$callable_name ]] )
验证变量的内容能否作为函数调用。 这可以检查包含有效函数名的变量，或者一个数组，包含了正确编码的对象以及函数名。

和使用require()相比，require_once()需要额外的开销。如果想尽可能地减少系统执行时间，应该考虑使用require()。

在使用文件系统函数（如fopen()或require()）时，如果没有找到相应的文件目录，就会在include_path指定的目录中自动查找--从inluce_path中指定的第一个目录开始找起（要使用本功能，需要指定fopen()函数的第三个参数为true）.直到找到目标文件时，停止搜索，由文件函数执行任务。
可以在php.ini中设置include_path目录。也可以用函数set_include_path()设置include_path查找目录。


class_exists — 检查类是否已定义

var_dump()和它的姊妹函数print_r()是检测php代码的利器，但对于类和函数，反射API提供了更高层次的功能。


回调函数：当向函数传递数据类型不能满足需求时，向函数中传递别一个函数。PHP是将函数以string形式传递的。
回调函数的经典案例：
<?php
    function large($i){
        if($i>50){
            return 1;//返回真
        }
    }

    function test($x,$y,$z){
        if($x<$y){
            for($i=$x;$i<$y;$i++){
                if($z($i)){//test传入的是large，$z()==large()
                    break;
                }
                echo $i."<br />";
            }
        }
    }
    
    test(10,100,'large');
?>


数组的内部指针控制函数(比较少用，了解下）
next(array)数组指针向后移动
prev(array)数组指针向前移动
reset(array)数组指针移动到第一个索引位置
end(array)数组指针移动到最后一个元素

each(array)也有指针向后移动的功效

key(array)获取数组当前指针的key
current(array)获取数组当前指针的value
注参考：[2014]兄弟连高洛峰.PHP教程.6.3.7.使用数组的内部指针控制函数遍历数组(ED2000.COM).mp4


数组比较有用的函数,兄弟连高洛峰有介绍的：
array_values — 返回数组中所有的值
array array_values ( array $array )

array_keys — 返回数组中部分的或所有的键名
array array_keys ( array $array [, mixed $search_value = null [, bool $strict = false ]] )

in_array — 检查数组中是否存在某个值
bool in_array ( mixed $needle , array $haystack [, bool $strict = FALSE ] )
大海捞针，在大海（haystack）中搜索针（ needle），如果没有设置 strict 则使用宽松的比较。 

array_search — 在数组中搜索给定的值，如果成功则返回首个相应的键名 
mixed array_search ( mixed $needle , array $haystack [, bool $strict = false ] )

array_key_exists — 检查数组里是否有指定的键名或索引
bool array_key_exists ( mixed $key , array $array )
注：isset()也可以判断一个值是否在数组中，但如果数组中的值为null则返回false.

array_flip — 交换数组中的键和值
array array_flip ( array $array )

array_reverse — 返回单元顺序相反的数组 
array array_reverse ( array $array [, bool $preserve_keys = false ] )

count — 计算数组中的单元数目，或对象中的属性个数
int count ( mixed $array_or_countable [, int $mode = COUNT_NORMAL ] )

array_unique — 移除数组中重复的值
array array_unique ( array $array [, int $sort_flags = SORT_STRING ] )

array_filter — 用回调函数过滤数组中的单元 
array array_filter ( array $array [, callable $callback [, int $flag = 0 ]] )

array_walk — 使用用户自定义函数对数组中的每个元素做回调处理
bool array_walk ( array &$array , callable $callback [, mixed $userdata = NULL ] )

array_map — 为数组的每个元素应用回调函数 
array array_map ( callable $callback , array $array1 [, array $... ] )


数组排序：
sort:对数组排序（升序），注：下标重新生成
rsort:对数组逆向排序(降序)，注：下标重新生成
ksort:对数组按键名排序。
krsort:对数组按键名逆向排序。
asort:对数组按值排序并保持下标索引关系。
arsort:对数组按值逆向排序并保持下标索引关系。
natsort:用“自然排序”算法对数组中的值进行排序。
natcasesort:用“自然排序”算法对数组进行不区分大小写字母的排序。
usort:使用用户自定义的比较函数对数组中的值进行排序。
uasort:使用用户自定义的比较函数对数组中的值进行排序并保持索引关系。
uksort:使用用户自定义的比较函数对数组中的键名进行排序。
array_multisort:对多个数组或多维数组进行排序。

array_multisort可对数据表进行排序。(不懂的话可看[2014]兄弟连高洛峰.PHP教程.6.5.15.PHP多维数组的排序函数(ED2000.COM).mp4)


sort()与asort()的排序区别：sort()会重新生成下标索引，asort会保持下标索引。

natsort — 用“自然排序”算法对数组排序 
bool natsort ( array &$array)
汪：与(strnatcmp — 使用自然排序算法比较字符串)的区别

natcasesort — 用“自然排序”算法对数组进行不区分大小写字母的排序
bool natcasesort ( array &$array )

sort()排序中如果有字符串和数字，先排序字符串再排序数字。

array_slice — 从数组中取出一段
array array_slice ( array $array , int $offset [, int $length = NULL [, bool $preserve_keys = false ]] )

array_combine — 创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值 
array array_combine ( array $keys , array $values )


数组合并：
“+”可以合并数组，但下标相同时会被覆盖。

array_merge — 合并一个或多个数组
array array_merge ( array $array1 [, array $... ] )
注：如果是数字索引数组，会重新排序，如果关联数组下标相同会覆盖。

array_intersect — 计算数组的交集
array array_intersect ( array $array1 , array $array2 [, array $... ] )

array_diff — 计算数组的差集
array array_diff ( array $array1 , array $array2 [, array $... ] )

其他用途：
array_push — 将一个或多个单元压入数组的末尾（入栈） 
int array_push ( array &$array , mixed $value1 [, mixed $... ] )
注：array[]=1;比array_push()效率高

array_pop — 弹出数组最后一个单元（出栈）
mixed array_pop ( array &$array )

array_unshift — 在数组开头插入一个或多个单元
int array_unshift ( array &$array , mixed $value1 [, mixed $... ] )

array_rand — 从数组中随机取出一个或多个单元
mixed array_rand ( array $array [, int $num = 1 ] )
注：返回的是下标。

shuffle — 打乱数组
bool shuffle ( array &$array )

array_sum — 对数组中所有值求和
number array_sum ( array $array )

range — 根据范围创建数组，包含指定的元素
array range ( mixed $start , mixed $end [, number $step = 1 ] )

array_fill — 用给定的值填充数组
array array_fill ( int $start_index , int $num , mixed $value )

php函数的不能重名。

------类start(兄弟连)>>>>>>>>>>>>>>>>>>>>>>>>>
类用class声明。

类成员属性前面一定要有一个修饰词。

用new声明一个对象。

用->访问对象的属性和方法。
对象的赋值用->

php类中的$this总是指向调用者的本身。

构造方法__constuct()：对象创建后第一个调用的方法，用于对象中的成员赋初始值0。
构造方法可以用类名作方法名，但后期修改类名的时候，要随类名更改。所以php5后用__constuct()更好。

析构函数__desturct():对象销毁前最后一个调用的函数。通常于打开资源，比如打开图片，打开文件，打开数据库。

php类的三大特性：封装性，继承性，多态性。

php5支持如下3种访问修饰符：
public:公有的，外面可以调用。
protected:受保护的，子类可以调用。
private:私有的，仅类的本身可以调用。用于封装一些外边不需要用的功能。比如一个打电话的类，播号功能设为public,信号怎么传输，怎么接收的功能设为private。看别人的代码只需要看别人的公开的public成员。


private修饰的属性不允许外面直接访问和赋值。但可以通过创建方法去访问和赋值。这样做的意义是可以设计范围。
ps:
<?php
    class Person{
        private $sex;
        public function __constuct($sex){
            $this->setSex($sex);//注意这里，可以限制初始化的值。
        } 
        public function setSex($sex){
            if(!($sex=='boy' || $sex=='girl')){
                return;
            }

            $this->sex=$sex;
        }

        public function getSex(){
            return $this->sex;
        }
    }

    $boy=new Person('boy');
    $boy->setSex('girl');
    echo $boy->getSex();
?>

__set():对私有成员（成员属性和成员方法）直接赋值的时候，自动调用。
__get():对私有成员直接获取的时候调用。

__isset():在使用isset()判断一个私有属性是否存在时，自动调用。
__unset():删除对象中的私有成员。
ps:
<?php
    class Person{
        public $name;
        private $age;
        private $salary;
        public function __construct($name,$age){
            $this->name=$name;
            $this->age=$age;
        }

        public function __isset($x){
            if($x=='salary'){
                echo '131313<br>';
                return false;
            }
            echo '16161616<br>';
            return isset($this->$x);
        }
    }

    $boy=new Person('xiaojing',26);

    if(isset($boy->salary)){
        echo 'exits<br>';
    }else{
        echo 'not exits<br>';
    }
?>

ps2:
<?php
    class Person{
        public $name;
        private $age;
        private $salary;
        public function __construct($name,$age){
            $this->name=$name;
            $this->age=$age;
        }

        public function __unset($x){
            echo '121212<br>';
            unset($this->$x);
        }

        public function __get($x){
            return $this->$x;
        }
}

    $boy=new Person('xiaojing',26);
    unset($boy->age);
//    echo $boy->age;
?>

子类使用 extends 继承父类。

继承的好处：
1.可以把子类都需要的代码放在父类，提高代码的重用性。
2.利于二次开发，在不改变原有类结构的情况下，在子类添加新功能。

parent:: 访问父类的成员。

self::可以在类中方法中，代表类的本身。

子类的权限只能等于或大于父类。如父类是protectd，子类可以是protected和public

instanceof 用于确定一个 PHP 变量是否属于某一类 class 的实例. 

final 关键字:如果父类中的方法被声明为 final，则子类无法覆盖该方法。如果一个类被声明为 final，则不能被继承。 

类和类的方法不允许修改可以用final,类的属性不允许修改可以用常量。

Static（静态）关键字:声明类属性或方法为静态，就可以不实例化类而直接访问。静态属性不能通过一个类已实例化的对象来访问（但静态方法可以）。 
特点：
1.使用static 修饰成员属性，存在内存的初始化静态段。
2.可以被所有同一个类的对象共用。
3.第一个用到类（类名第一次出现），类在加载到内存时，就已经将静态的成员加到内存。
4.静态的成员要用类名来访问,classname::property 
5.self::可以在类中方法中，代表类的本身。self::可以在类中方法中，代表类的本身。self::可以在类中方法中，代表类的本身。self::可以在类中方法中，代表类的本身。self::可以在类中方法中，代表类的本身。
6.静态成员一旦被加载，只有脚本结束才释放。
7.缺点：在静态方法中，是不能访问非静态的成员的。原因：$this是指向本对象，而静态方法是不用创建新对象才调用。
8.优点：只要能用静态的环境下声明方法，就最好使用静态方法。（效率高）


单态（单例，单件）设计模式--最适合php使用的设计模式
1.如果想让一个类(如数据库连接类)，只能有一个对象，就要先让这个类，不能创建对象，将构造方法设为private
2.可以在类的内部使用一个方法来创建对象。
3.在类的内部，设一个静态属性来判断对象是否已创建过。
ps:
<?php
    class Person{
        static $obj=null;
        private function __construct(){
        
        }
        public static function getObj(){
            //如果第一次调用，则创建对象，否则直接使用第一次创建的对象
            if(is_null(self::$obj)){
                self::$obj=new self;
            }
            return self::$obj;
        }
        public function __destruct(){
            echo 'Release object__xj##########<br>';
        }
    }

    $boy=Person::getObj();

    $girl=Person::getObj();
?>

类中的常量用const修饰，const只能修饰成员属性。
1.常量建议使用大写，不能使用$
2.常量一定要声明时就给好初值（因为常量不能改值）
3.常量的访问方式和static的访问方式相同。
a.在类的外部使用 className::ConstantName
b.在类中访问用 self::constantName

final修饰类和方法。
static修饰属性和方法。
const只能修饰属性。


php中的魔术方法都是自动解发调用。但都有自己的解发条件。

__toString()
1.是在直接使用echo print printf输出一个对象引用时自动调用。
2.可以将对象的基本信息放在__toString()中，形成字符串返回。
3.__toString()中不能有参数，而且必须返回一个字符串。

克隆对象
1.使用clone关键字复制一个对象。


__clone()魔术方法
1.是在克隆对象时，自动调用的方法。
2.作用：和构造方法一样，是对新克隆对象进行初始值。
3.在__clone()方法中$this代表克隆的对象，所以可以对克隆的对象赋初始值。
ps:
<?php
    class Person{
        public $name='king';

        public function __destruct(){
            echo "$this->name @@@@@@@@@@@@@@@@@@<br>";
        }

        public function __clone(){
            $this->name='xiaojing';
        }
    }

    $obj=new Person();
    $obj2=clone $obj;
?>

__call()
1.就是在调用一个对象中不存在的方法时，自动调用的方法。
2.有2个参数，第一个参数是调用的不存在的方法名，第二个参数是调用这个不存在方法的参数。
3.作用：可以写提示，但这个不是主要的功能。将方法的功能相似，但方法名不同的，就可以采用这个方式来完成。
ps:
<?php
    header("Content-Type: text/html; charset=UTF-8");
    class Person{
        public function __call($method,$args){
            echo "你调用的函数 $method() 不存在。";
            echo "你调用的参数为：";
            print_r($args);
        } 
    }

    $boy=new Person();
    $boy->say();
?>


串行化（序列化）
1.将对象转成字符串(不用看懂内容)
    __sleep()在串行化时自动调用的方法。
    作用：可以设置需要串行化的对象属性。只要在这个方法中，返回一个数组，在数组中声明了哪个属性名，哪个属性就被串行化，没有在数组中的就不被串行化。
2.将字符串转回字符串
    __wakeup()在返串行化时自动调用的方法。
    作用：对象串行化回来的对象，进行初始化。作用和__construct()和__clone()相似.

串行化的时机：
1.将对象在网络中传输.
2.将对象持久保存。

所有php里面的值都可以使用函数serialize()来返回一个包含字节流的字符串来表示。unserialize()函数能够重新把字符串变回php原来的值。 序列化一个对象将会保存对象的所有变量，但是不会保存对象的方法，只会保存类的名字。
ps:
<?php
    class Person{
        public $name;
        public function __construct($name){
            $this->name=$name;
        }
    }
    $boy=new Person('king');
    $str=serialize($boy);
    var_dump($str);

    echo '<hr>';

    $boy2=unserialize($str);
    var_dump($boy2);
?>


数组串行化（JSON格式）
json_decode — 对 JSON 格式的字符串进行解码,可返回对象，也可以返回数组，只要设置参数。
mixed json_decode ( string $json [, bool $assoc = false [, int $depth = 512 [, int $options = 0 ]]] )
    注：assoc:当该参数为 TRUE 时，将返回 array 而非 object 。

json_encode — 对变量进行 JSON 编码

eval() — 把字符串作为PHP代码执行

var_export() — 输出或返回一个变量的字符串表示
注：var_export()函数返回关于传递给该函数的变量的结构信息，它和var_dump()类似。不同的是其返回的表示是合法的php代码。var_export必须返回合法的php代码，也就是说，var_export返回的代码，可以直接当作php代码赋值个一个变量。而这个变量就会取得和被var_export一样的类型的值。
ps:
不懂可以参考：[2014]兄弟连高洛峰.PHP教程.7.7.12.魔术方法__set_state()(ED2000.COM).mp4
<?php
    $str="echo 'kingaa';";
    eval($str);
    echo '<br>';
    $arr=['x'=>'xiaojing','h'=>'haining','l'=>'lanpei'];

    $a=eval('$b='.var_export($arr,true).";");

    var_dump($b);
    echo '<br>';
    echo $b['x'];
?>

__set_state()
static object __set_state ( array $properties )
自 PHP 5.1.0 起当调用 var_export() 导出类时，此静态 方法会被调用。 


__invoke()
mixed __invoke ([ $... ] )
当尝试以调用函数的方式调用一个对象时，__invoke() 方法会被自动调用。 
ps:
<?php
class Person{
    
    public function __invoke($a,$b){
        echo $a+$b;
    }
}

$boy=new Person();
$boy(3,7);
?>

__callstatic()
在静态上下文中调用一个不可访问方法时，__callStatic() 会被调用。 


__autoload — 尝试加载未定义的类.
在脚本中，需要加载类的时候，就会自动调用这个方法。
ps:
file:   say.class.php
<?php
class say{
    public function saygood(){
        return 'say goodbly<br>';
    }
}
?>
file2:  index.php
<?php
    function __autoload($className){
        include strtolower($className).".class.php";
    }
    $boy=new say();
    echo $boy->saygood();
?>


什么是抽象方法？
定义：一个方法如果没有方法体，则这个方法就是抽象方法。
1.声明一个方法，不使用{},而直接分号结束。
2.如果是抽象方法，必须使用abstract修饰。

什么是抽象类？
1.如果一个类中有一个方法是抽象方法，则这个类就是抽象类。
2.如果声明一个抽象类，则这个类必须使用abstract关键字修饰。
3.抽象类不能实例化对象。
4.继承一个抽象类的时候，子类必须定义父类中的所有抽象方法；另外，这些方法的访问控制必须和父类中一样（或者更为宽松）。
5.如果子类只继承了部分抽象方法，则这个子类必须声明为抽象类。

注意：
1.只要使用abstract修饰的类，就是抽象类。
2.抽象类是一种特殊的类，特殊的地方就是，在抽象类中可以有抽象方法。
3.除了在抽象类中可以有抽象方法以外，和正常的类完全一样。
ps:
abstract class Person{
    abstract function say();
}

抽象方法的作用：抽象方法规定了子类必须有这个方法的实现，功能交给子类。
抽象类的作用：就是要求子类的结构，所以抽象类就是一个规范。


接口
抽象类是一种抽象的类，接口是一种特殊的抽象类。
1.抽象类和接口中都有抽象方法。
2.抽象类和接口都不能实例化对象。
3.抽象类和接口的使用意义也就是作用相同。都是定义一种规范。

接口和抽象类相比，特殊在哪里？
1.接口中的方法，必须全是抽象方法（不能有不抽象的方法存在）。所以在接口中的抽象方法不需要使用abstract，直接使用结束即可。
2.接口的成员属性，必须是常量（不能有变量）。
3.所有的权限必须是public，不写默认是public.
4.声明接口不使用class，而是使用interface
ps:
interface Person{
    const NAME='king';
    oabstract function say();
}


接口应用的一些细节：
1.可以使用extends让一个接口继承另一个接口（接口和接口，只有扩展新抽象方法，没有覆盖的关系）。
2.可以使用一个类来实现接口中的全部方法，也可以使用一个抽象类来实现接口中的部分方法。（类与接口，抽象类与接口，有覆盖重写接口中的抽象方法）
3.使用implements关键字实现接口。
4.一个类可以继承另一个类的同时，使用implements实现一个或多个接口。
5.实现多个接口，只需要使用逗号分开多个接口即可。
ps:
class Boy extends Person implements Test,Say{
}


多态特性
注：辅助理解案例子（开发电脑后，定义usb的规范，其他设备厂商按照规范生产带ubs接口的设备）,可以看案例[2014]兄弟连高洛峰.PHP教程.7.10.1.PHP图形计算器需求分析(ED2000.COM).mp4
作用：程序扩展准备

技术：必须有继承关系，父类最好是接口或抽象类。

命名空间
解决php中不能重名的问题。不能重名的有：
1.常量名
2.函数名
3.类名

命名空间通过关键字namespace 来声明。
如果一个文件中包含命名空间，它必须在其它所有代码之前声明命名空间，除了一个以外：declare关键字。
ps:
<?php
    namespace xj;
    const ROOT='xjRoot<br>';

    echo ROOT;//使用当前目录下访问
    echo \xj\ROOT;//使用绝对目录访问
?>

定义子命名空间
与目录和文件的关系很象，PHP 命名空间也允许指定层次化的命名空间的名称。因此，命名空间的名字可以使用分层次的方式定义： namespace MyProject\Sub\Level;

也可以在同一个文件中定义多个命名空间。在同一个文件中定义多个命名空间有两种语法形式.
注：开发中不提倡在同一个文件中定义多个命名空间。不要在{}外不要加其他代码。


命名空间和动态语言特征
PHP 命名空间的实现受到其语言自身的动态特征的影响。如下：必须使用完全限定名称（包括命名空间前缀的类名称）。注意因为在动态的类名称、函数名称或常量名称中，限定名称和完全限定名称没有区别，因此其前导的反斜杠是不必要的。
<?php
    namespace king;
    function demo(){
        echo '777777';
    }
    $fun='demo';
    //$fun='\king\demo';这样子才可以。
    $fun();
?>

PHP支持两种抽象的访问当前命名空间内部元素的方法，__NAMESPACE__ 魔术常量和namespace关键字。

常量__NAMESPACE__的值是包含当前命名空间名称的字符串。在全局的，不包括在任何命名空间中的代码，它包含一个空的字符串。 

关键字 namespace 可用来显式访问当前命名空间或子命名空间中的元素。它等价于类中的 self 操作符。 


使用命名空间：别名/导入
ps：起别名king
1. namespace hello\work as king
2. namespace demo1\king //注：没有as的时候，最后一个为别名

导入也是用use.

<<<<<<<<<<<<<<<<<<<<<<<<<<<<类start(兄弟连)

学字符串主要学习：分割，查找，替换
count()可以统计字符串，返回都是1.

utf-8格式下，一个中文占三个字符。
gb2312格式下，一个中文占两个字符。

双引号中解释数组，如果用{}隔开，可以包含有2个单引号或者2个双引号。
ps1:
<?php
    $arr=['x'=>'xiao','j'=>'jing'];
    echo "{$arr["x"]} is good boy!";  //注意"

ps2:
<?php
    $arr=['x'=>'xiao','j'=>'jing'];
    echo "$arr['x'] is good boy！";//运行到$arr['这里就会报错。
    echo "$arr[x] is good girl!";//可以运行。


多字节字符串处理(重点)
系统中字符串函数基本都有mb_开头的函数配套函数。(只有处理中文的时候才用，因为效率低)

常用的输出字符串函数：
echo()-- 输出字符串.
print()--输出一个字符串。
die()--输出一条消息，并退出当前脚本。
printf()--输出格式化字符串.
sprintf()--把格式化的字符串写入一个变量中

echo()与print()的区别：
1.echo()没有返回值。print()有返回值。
2.echo()在指令条件下可以连续输出多个值，print()不可以。
ps:
echo 'xiao','jing','good';//可以运行。
echo('xiao','jing','good');//不可以运行。

die()是exit()的别名的关系。

printf()和sprintf()都是格式化输出。（了解下，不用重点）
字符串转换格式：
%% 返回百分比符号。
%b  二进制数。
%c 依照ASCII值的字符。
%d  带符号的十进制数。
%e  可续计数法（如1.5e3)
%u  无符号十进制数。
%f或%F  浮点数
%o  八进制
%s  字符串
%x或%X  十六进制数。

ps1:printf("$b",10);//直接输出1010
ps2:$sum=printf("$b",10);//没有输出，把1010赋值给$sum


trim和ltrim,rtime注意事项：
<?php
    $str=' 26856hello World62356 ';
    var_dump(trim($str,' 1234567890'));//把两边有数字和空格的全删掉
    var_dump(trim($str,'0..9 hd'));//把两边有数字和空格，和字符h,d的都删掉。
    var_dump(trim($str,'0..9a..z '));//过滤掉两边数字和小写字母和空格。
?>

str_pad — 使用另一个字符串填充字符串为指定长度
string str_pad ( string $input , int $pad_length [, string $pad_string = " " [, int $pad_type = STR_PAD_RIGHT ]] )

<?php
    $input = "Alien";
    echo str_pad($input, 10);                      // 输出 "Alien     "
    echo str_pad($input, 10, "-=", STR_PAD_LEFT);  // 输出 "-=-=-Alien"
    echo str_pad($input, 10, "_", STR_PAD_BOTH);   // 输出 "__Alien___"
    echo str_pad($input,  6, "___");               // 输出 "Alien_"
    echo str_pad($input,  3, "*");                 // 输出 "Alien"
?>

ucwords — 将字符串中每个单词的首字母转换为大写




转义字符，转义，敝免sql注入,敝免html注入
htmlspecialchars — 将特殊字符转换为 HTML 实体

 string htmlspecialchars ( string $string [, int $flags = ENT_COMPAT | ENT_HTML401 [, string $encoding = ini_get("default_charset") [, bool $double_encode = true ]]] )

某类字符在 HTML 中有特殊用处，如需保持原意，需要用 HTML 实体来表达。 本函数会返回字符转义后的表达。 如需转换子字符串中所有关联的名称实体，使用 htmlentities() 代替本函数。

如果传入字符的字符编码和最终的文档是一致的，则用函数处理的输入适合绝大多数 HTML 文档环境。 然而，如果输入的字符编码和最终包含字符的文档是不一样的， 想要保留字符（以数字或名称实体的形式），本函数以及 htmlentities() （仅编码名称实体对应的子字符串）可能不够用。 这种情况可以使用 mb_encode_numericentity() 代替。

执行转换 字符 	替换后
& (& 符号) 	&amp;
" (双引号) 	&quot;，除非设置了 ENT_NOQUOTES
' (单引号) 	设置了 ENT_QUOTES 后， &#039; (如果是 ENT_HTML401) ，或者 &apos; (如果是 ENT_XML1、 ENT_XHTML 或 ENT_HTML5)。
< (小于) 	&lt;
> (大于) 	&gt;

//'"(这行去掉变色用，不用管)
ps:
<?php
    $new = htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
    echo $new; // &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;
?>


htmlspecialchars_decode — 将特殊的 HTML 实体转换回普通字符 
 string htmlspecialchars_decode ( string $string [, int $flags = ENT_COMPAT | ENT_HTML401 ] )

此函数的作用和 htmlspecialchars() 刚好相反。它将特殊的HTML实体转换回普通字符。

被转换的实体有： &amp;， &quot; （没有设置ENT_NOQUOTES 时）, &#039; （设置了 ENT_QUOTES 时）， &lt; 以及&gt;。 



addslashes

(PHP 4, PHP 5, PHP 7)

addslashes — 使用反斜线引用字符串
说明
string addslashes ( string $str )

返回字符串，该字符串为了数据库查询语句等的需要在某些字符前加上了反斜线。这些字符是单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）。

一个使用 addslashes() 的例子是当你要往数据库中输入数据时。 例如，将名字 O'reilly 插入到数据库中，这就需要对其进行转义。 强烈建议使用 DBMS 指定的转义函数 （比如 MySQL 是 mysqli_real_escape_string()，PostgreSQL 是 pg_escape_string()），但是如果你使用的 DBMS 没有一个转义函数，并且使用 \ 来转义特殊字符，你可以使用这个函数。 仅仅是为了获取插入数据库的数据，额外的 \ 并不会插入。 当 PHP 指令 magic_quotes_sybase 被设置成 on 时，意味着插入 ' 时将使用 ' 进行转义。

PHP 5.4 之前 PHP 指令 magic_quotes_gpc 默认是 on， 实际上所有的 GET、POST 和 COOKIE 数据都用被 addslashes() 了。 不要对已经被 magic_quotes_gpc 转义过的字符串使用 addslashes()，因为这样会导致双层转义。 遇到这种情况时可以使用函数 get_magic_quotes_gpc() 进行检测。


<?php
$str = "Is your name O'reilly?";

// 输出： Is your name O\'reilly? //'
echo addslashes($str);
?>

stripslashes — 反引用一个引用字符串
说明:string stripslashes ( string $str )

反引用一个引用字符串。

    Note:如果 magic_quotes_sybase 项开启，反斜线将被去除，但是两个反斜线将会被替换成一个。

一个使用范例是使用 PHP 检测 magic_quotes_gpc 配置项的 开启情况（在 PHP 5.4之 前默认是开启的）并且你不需要将数据插入到一个需要转义的位置（例如数据库）。例如，你只是简单地将表单数据直接输出。


strip_tags — 从字符串中去除 HTML 和 PHP 标记
string strip_tags ( string $str [, string $allowable_tags ] )

该函数尝试返回给定的字符串 str 去除空字符、HTML 和 PHP 标记后的结果。它使用与函数 fgetss() 一样的机制去除标记。 


nl2br — 在字符串所有新行之前插入 HTML 换行标记
说明:string nl2br ( string $string [, bool $is_xhtml = true ] )
在字符串 string 所有新行之前插入 '<br />' 或 '<br>'，并返回。

md5()被破解原理
现在有一些网站把大量可能用的密码，用md5加密后的序列保存为一个数据库。然后把你输入的md5()加密后的序列匹配。
所以md5()加密最好有两层或三层以上。
如：md5(md5($_POST['password'].'xiaojing'));

字符串的比较：
1.用等号去区分两个字符串是否相等。
2.字符比较
    strcmp()
    strcasecmp()
3.按自然排序法
    strnatcmp()
    strnatcase()

用strcmp()也可以判判两个字符串是否相等。注意这个函数有返回值。
strcmp — 二进制安全字符串比较
int strcmp ( string $str1 , string $str2 )
ps:

<?php
    $var1 = "Hello";
    $var2 = "hello";
    if (strcmp($var1, $var2) !== 0) {
        echo '$var1 is not equal to $var2 in a case sensitive string comparison';
    }
?>

strcasecmp — 二进制安全比较字符串（不区分大小写）

strnatcmp — 使用自然排序算法比较字符串
int strnatcmp ( string $str1 , string $str2 )
与其他字符串比较函数类似，如果 str1 小于 str2 返回 < 0； 如果 str1 大于 str2 返回 > 0；如果两者相等，返回 0。 
ps:
<?php
    $a='file11.txt';
    $b='file2.txt';//普通排序是先比较1和2，自然排序是比较11和2
    var_dump(strnatcmp($a,$b));
?>

strnatcasecmp — 使用“自然顺序”算法比较字符串（不区分大小写）
