--TEST--
Extra arguments overload
--SKIPIF--
<?php include __DIR__ . '/../skipif.inc'; ?>
--FILE--
<?php
use Aspekt\JoinPoint;
use Aspekt\Interceptor;

function test($p1, $p2 = 200) {
    $a = 100;

    print_r(get_defined_vars());
    return $p2 + $a;
}

$interceptor = new Interceptor();
$interceptor->addBefore('test()', function (JoinPoint $jp) {
    $args = $jp->getArguments();
    $args[1] = 300;
    $args[2] = 'extra arg';

    $jp->setArguments($args);
});

echo test('hello world', new stdClass, [123456789]);
?>
--EXPECT--
Array
(
    [p1] => hello world
    [p2] => 300
    [a] => 100
)
400
