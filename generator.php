<?php

class StringGenerator
{
 
  // Текст с метками для замены
  private $generator = '';
  // Массив с вариантами для замены
  private $replacements = array();
  // Метка для замены
  private $replaceSymbol = 'RPLC';
  // Массив сгенерированных строк
  private $outputs = array();
 
  /**
   * Constructor.
   *
   * @param string $template
   */
  public function __construct(string $template)
  {
    $this->setTemplate($template);
  }
 
  /**
   * Set шаблона 
   *
   * @param string $template
   */
  public function setTemplate(string $template)
  {
    $this->prepare($template);
    $this->processReplacements(
    	1,
    	1,
    	$this->generator
    );
  }
 
  /**
   * $count рандомных строк без повторения из сгенерированых строк
   *
   * @param int $count
   * @return array
   */
  public function generate(int $count)
  {
    $used = [];
    while (count($used) < $count) {
      $rand = mt_rand(0, count($this->outputs) - 1);
      if (!in_array($rand,$used)) {
        $used[] = $rand;
        $result[] = $this->outputs[$rand];
      }
      
    }

    return $result;
  }
 
  /**
   * Подготовка $template к перебору.
   *
   * @param string $template
   */
  private function prepare(string $template)
  {
    // ID для массива заменителей.
    $rid = 0;
    $replacements = array();
 
    // Цикл продолжается пока есть {a|b|c}.
    while (preg_match_all("/{([^{}]+)}/", $template, $matches)) {
 
      foreach ($matches[1] as $match) {
      	//Вставка метки вместо возможных значений {a|b|c}
        $rid++;
        $replace = "{" . $match . "}";
        $template = str_replace($replace, '_' . $this->replaceSymbol . $rid . '_', $template);
        
        //Запоминем возможные значения
        $elements = explode('|', $match);
        foreach ($elements as $element) {
          $replacements[$rid][] = $element;
        }
      }
    }
    
    $this->replacements = $replacements;
    $this->generator = $template;
  }
 
 
  /**
   * Рекурсивная функция которая перебирает все возможные варианты и запоминает в $outputs.
   *
   * @param int $i - индекс с которого начинается перебор.
   * @param int $position - Позиция в которой производится замена
   * @param string $text - Текст в котором производится работа
   */
  private function processReplacements(int $i, int $position, string $text)
  {
    for ($j = 0 ; $j < count($this->replacements[$i]); $j++) { 

      if (count($this->replacements) == $i) {
        $this->outputs[] = str_replace('_' . $this->replaceSymbol . $position . '_', $this->replacements[$i][$j], $text);
      } else {
        $res = str_replace('_' . $this->replaceSymbol . $position . '_', $this->replacements[$i][$j], $text);
        $this->processReplacements(
        	$i + 1,
        	$position + 1,
        	$res
        );        
      }
    }
  }

}

?>