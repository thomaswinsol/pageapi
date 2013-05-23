<?php
class My_Form extends Zend_Form
{
    protected $updateMode;    
    protected $defaultDecorator;    
    protected $defaultDecoratorOptions;
    protected $baseUrl = '/winplan/public';
    
	protected $elementDecorators = array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array('label', array('tag' => 'th')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		);

	protected $buttonDecorators = array(
		'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tfoot')),
	);    
       
        protected $formJQueryElements = array(
        array('UiWidgetElement', array('tag' => '')), // it necessary to include for jquery elements
        array('Errors'),
        array('Description', array('tag' => 'span')),
        array('HtmlTag', array('tag' => 'td')),
        array('Label', array('tag' => 'th')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
	);

     /**
     * Create a new form
     *
     * @param $boolean $updateMode TRUE = update, FALSE = create
     * @param mixed $options
     */
    public function __construct($id = NULL, $options = NULL)
    {
        /*echo 'form options is : ';
    	var_dump($options);
        exit();*/

        if (isset($options['action'])) {
            if (!is_null($id)) {
                if (strpos(rtrim($options['action'], '/'), '/', 1) == FALSE) {
                    $options['action'] .= "/detail/id/$id";
                } else {
                    $options['action'] .= "/id/$id";
                }
            } else {
                if (strpos(rtrim($options['action'], '/'), '/', 1) == FALSE) {
                    $options['action'] .= "/detail";
                }
            }
        }
        
         $this->defaultDecoratorOptions = array(
            'ViewHelper',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        );
        
        // decorator for all elements:
        
        $this->defaultDecorator = new My_Form_Decorator_Default();
        
        parent::__construct($options);

        $this->updateMode = !is_null($id);

        if ($this->isUpdate()) {
            // Id
			$elem = new Zend_Form_Element_Hidden('id', array(
				'decorators' => $this->elementDecorators,
				'value'      => (int)$id)
			);		
            $this->addElement($elem);            
        }

         // errors decorator
         
        $this->addDecorator(new My_Form_Decorator_FormErrors(array(
            'placement' => Zend_Form_Decorator_Abstract::PREPEND,
            'message' => 'Some errors were encountered while processing your request:',
        )));


    }

    /**
     * Check if form is in update mode
     * @return boolean
     */
    public function isUpdate()
    {
        return $this->updateMode;
    }

    /**
     * Check if form is in create mode
     * @return boolean
     */
    public function isCreate()
    {
        return !$this->updateMode;
    }
    
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table' ,'class' => 'frm_01')),
            'Form',
        ));
    }    
 
}
