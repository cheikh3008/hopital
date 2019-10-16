<?php
    class Formulaire extends ConnexionDB{

    // Methode qui génége un label et un champs de type (text,email,tel,date,number...)
        public function formInput($label,$type,$name,$placeholder,$value=''){
            return "
            <div class=\"form-group \">
                    <label for=\"input$name\">$label</label>
                    <input type=\"$type\" class=\"form-control col-md-2\" name=\"$name\" value=\"$value\" id=\"input$name\"          placeholder=\"$placeholder\">
    
            </div>";
        }

        // Methode qui génége un select liste simple
        public function selectList($label,$name,$option){
            
            return "  
                <div class=\"form-group\">
                    <label for=\"input$name\">$label</label>
                    <select id=\"input$name\" name=\"$name\" class=\"form-control\">$option</select>
                </div>";
        }

        // Methode qui génége un input de submit 
        public function formSubmit($name,$value){
            return  "<input type='submit'  name=\"$name\" value=\"$value\" class=\"btn btn-primary\"><br>";
            }
        

            public function formInputValue($label,$type,$name,$placeholder,$value){
                return 
                "<div class=\"form-group\">
                    <label for=\Input$type\ >$label</label>
                    <input type=\"$type\" name=\"$name\" class=\"form-control col-md-4\" id=\"Input$type\" value=\"$value\" placeholder=\"$placeholder\">
                </div>";
            }
        
            public function selectListValue($label,$name,$value,$option){
            
                return "  
                    <div class=\"form-group\">
                        <label for=\"input$name\">$label</label>
                        <select id=\"input$name\" name=\"$name\" class=\"form-control col-md-4\">
                            <option value='$value'>$option</option>
                        </select>
                    </div>";
            }
           
   
    }
  
?>    