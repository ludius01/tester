<?php
 function upload($request){

        $exstensi1 = ['jpg','jpeg','png'];
        $nama1 = $_FILES['foto']['name'];
        $error = $_FILES['foto']['error'];
        $ukuran = $_FILES['foto']['size'];
        $tmpname = $_FILES['foto']['tmp_name'];
    
        $x = explode('.', $nama1);
        $exstensi=strtolower(end($x));
        
    
        if( $error === 4){
            // echo "<script> alert('pilih gambar');javascript:history.back() </script>";
            return '1' ;
        }
    
        if(!in_array($exstensi,$exstensi1)){
           
            echo "<script> alert('pilih jpg'); javascript:history.back()</script>";
            return false ;
        }
    
        if ($ukuran > 4000000 ) {
    
           
                echo "<script> alert('ukuran gambar terlalu besar'); javascript:history.back()</script>"; 
                return false;
            }
    
        $namafile = uniqid();
        $namafile .= '.';
        $namafile .= $exstensi;
    
        // move_uploaded_file($tmpname, '../../../storage/app/profil/'.$namafile);
        $a = $request->file('foto')->store('profil');
        // Storage::delete('storage/'.$profil);
        // $profil= $request->file('foto')->store('profil');
        
        return $a;

    }
    ?>