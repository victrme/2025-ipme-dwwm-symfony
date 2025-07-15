<?php

$finder = (new PhpCsFixer\Finder())
	->in(__DIR__);

return (new PhpCsFixer\Config())
	->setRules([
		'@Symfony' => true,
	])
	->setFinder($finder)
	->setIndent("\t")
	->setLineEnding("\r\n")
;
