<div class="kartings">
    <h1>Conheça os kartódromos onde realizamos nosso campeonato!</h1>
    <?php   foreach ($kartings as $kartings){
        echo '<div class="karting">';
            echo '<h1><img src="'.$kartings->logo.'"/>'.$kartings->title.'</h1>';
            echo '<div class="endkarting"><h2>Localização</h2><p>';
                if(!empty($kartings->street)){
                    echo $kartings->street;
                }
                if(!empty($kartings->number)){
                    echo ', '.$kartings->number;
                }
                if(!empty($kartings->district)){
                    echo ' - '.$kartings->district;
                }
                if(!empty($kartings->cep)){
                    echo ' - CEP: '.$kartings->cep;
                }
                if(!empty($kartings->city)){
                    echo ' - '.$kartings->city;
                }
                echo '</p>';
                echo '<h2>Contato</h2><p>';
                if((!empty($kartings->phone_fix))||(!empty($kartings->phone_fix1))){
                    echo 'Telefone: ';
                    if(!empty($kartings->phone_fix)){
                        echo $kartings->phone_fix;
                    }
                    if(!empty($kartings->phone_fix1)){
                        echo ' / '.$kartings->phone_fix1;
                    }
                }
                if((!empty($kartings->mobile_phone))||(!empty($kartings->mobile_phone1))){
                    echo '<br>Celular: ';
                    if(!empty($kartings->mobile_phone)){
                        echo $kartings->mobile_phone;
                    }
                    if(!empty($kartings->mobile_phone1)){
                        echo ' / '.$kartings->mobile_phone1;
                    }
                }
                echo '</p>';
                if((!empty($kartings->email))||(!empty($kartings->email1))){
                    echo '<p>E-mail: ';
                    if(!empty($kartings->email)){
                        echo $kartings->email;
                    }
                    if(!empty($kartings->email1)){
                        echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$kartings->email1;
                    }
                }
                echo '</p>';
                if(!empty($kartings->site)){
                    echo '<p>Site: <a href="http://'.$kartings->site.'">'.$kartings->site.'</a></p>';
                }
                if(!empty($kartings->description)){
                    echo '<h2>Detalhes</h2><p>'.$kartings->description.'</p>';
                }
            echo '</div>';
        
            if(!empty($kartings->map)){
                echo '<div class="kartingmap"><iframe src="'.$kartings->map.'"></iframe></div>';
            }
            
            echo '<div class="kartingfotos">
                    <h2>Imagens</h2>
                    <div>{AG}kartodromos/'.$kartings->folder.'{/AG}</div>
                    </div>';
        
        echo '</div>';
    }
    ?>
</div>
