<?php
 function upload($request){


        $exstensi1 = ['pdf'];
        $nama1 = $_FILES['pdf']['name'];
        $error = $_FILES['pdf']['error'];
        $ukuran = $_FILES['pdf']['size'];
        $tmpname = $_FILES['pdf']['tmp_name'];
    
        $x = explode('.', $nama1);
        $exstensi=strtolower(end($x));
        
    
        if( $error === 4){
           
            // echo "<script> alert('pilih pdf'); </script>";
            return '1';
        }
    
        if(!in_array($exstensi,$exstensi1)){
           
            echo "<script> alert('pilih pdf'); javascript:history.back()</script>";
            return false ;
        }
    
        if ($ukuran > 5000000 ) {
    
                echo "<script> alert('ukuran pdf terlalu besar');  javascript:history.back() </script>"; 
                return false;
            }
    
        $namafile = $nama1;
        $namafile .= '.';
        // $namafile .= $exstensi;
        
    
        // move_uploaded_file($tmpname, '../../../storage/app/profil/'.$namafile);
        $a = $request->file('pdf')->store('pdf');
        // Storage::delete('storage/'.$profil);
        // $profil= $request->file('foto')->store('profil');
        
        return $a;

    }
    ?>