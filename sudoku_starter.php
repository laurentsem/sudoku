<?php

/**
 * Charge un fichier en fournissant son chemin
 * @param string $filepath Chemin du fichier
 * @return array|null Un tableau si le fichier existe et est valide, null sinon
 */
function loadFromFile(string $filepath): ?array {//lolo
    $fichier = file_get_contents($filepath);

   if ($fichier === false) {
       return null;
   }

   $tab = json_decode($fichier, true);
   if ($tab === null) {
       return null;
   }
   return $tab;
}

/**
 * Retourne la valeur d'une cellule
 * @param int $rowIndex Index de ligne
 * @param int $columnIndex Index de colonne
 * @return int Valeur
 */
function get(array &$grid, int $rowIndex, int $columnIndex): int {//tiene
    
    return $grid[$rowIndex][$columnIndex];  
}

/**
 * Affecte une valeur dans une cellule
 * @param int $rowIndex Index de ligne
 * @param int $columnIndex Index de colonne
 * @param int $value Valeur
 */
function set(array $grid, int $rowIndex, int $columnIndex, int $value): void {//tiene
    $grid[$rowIndex][$columnIndex] = $value;  
}

/**
 * Retourne les données d'une ligne à partir de son index
 * @param int $rowIndex Index de ligne (entre 0 et 8)
 * @return array Chiffres de la ligne demandée
 */
function row(array $grid, int $rowIndex): array {//tiene
    foreach($grid[$rowIndex] as $key){
        $returnRow[] = $key;
    }
    return $returnRow; 
    
}

/**
 * Retourne les données d'une colonne à partir de son index
 * @param int $columnIndex Index de colonne (entre 0 et 8)
 * @return array Chiffres de la colonne demandée
 */
function column(array $grid, int $columnIndex): array {//tiene
    foreach($grid as $ligne){
        $returnColumn [] = $ligne[$columnIndex]; 
    }
    return $returnColumn;
}

/**
 * Retourne les données d'un bloc à partir de son index
 * L'indexation des blocs est faite de gauche à droite puis de haut en bas
 * @param int $squareIndex Index de bloc (entre 0 et 8)
 * @return array Chiffres du bloc demandé
 */
function square(array $grid, int $squareIndex): array {//marie
    switch ($squareIndex){
        case 0 : 
        for($ligne = 0; $ligne < 3; $ligne++){
            for($column = 0; $column < 3; $column++){
                $returnSquare[] = $grid[$ligne][$column]; 
            }
        }
        return $returnSquare; 
        case 1 : 
        for($ligne = 0; $ligne < 3; $ligne++){
            for($column = 1; $column < 3; $column++){
                $returnSquare[] = $grid[$ligne][$column]; 
            }
        }
        return $returnSquare;
        case 2 : 
        for($ligne = 0; $ligne < 3; $ligne++){
            for($column = 2; $column < 3; $column++){
                $returnSquare[] = $grid[$ligne][$column]; 
            }
        }
        return $returnSquare;
        case 3 : 
        for($ligne = 1; $ligne < 3; $ligne++){
            for($column = 0; $column < 6; $column++){
                $returnSquare[] = $grid[$ligne][$column]; 
            }
        }
        return $returnSquare;
        case 4 : 
        for($ligne = 1; $ligne < 3; $ligne++){
            for($column = 1; $column < 6; $column++){
                $returnSquare[] = $grid[$ligne][$column]; 
            }
        }
        return $returnSquare;
        case 5 : 
        for($ligne = 1; $ligne < 3; $ligne++){
            for($column = 2; $column < 6; $column++){
                $returnSquare[] = $grid[$ligne][$column]; 
            }
        }
        return $returnSquare;
        case 6 : 
        for($ligne = 2; $ligne < 3; $ligne++){
            for($column = 0; $column < 9; $column++){
                $returnSquare[] = $grid[$ligne][$column]; 
            }
        }
        return $returnSquare;
        case 7 : 
        for($ligne = 2; $ligne < 3; $ligne++){
            for($column = 1; $column < 9; $column++){
                $returnSquare[] = $grid[$ligne][$column]; 
            }
        }
        return $returnSquare;
        case 8 : 
        for($ligne = 2; $ligne < 3; $ligne++){
            for($column = 3; $column < 9; $column++){
                $returnSquare[] = $grid[$ligne][$column]; 
            }
        }
        return $returnSquare;
    }
}

/**
 * Génère l'affichage de la grille
 * @return string
 */
function display(array $grid): void {
    for($i=0; $i < 9; $i++){
        for($j=0; $j < 9; $j++){
            $val = $grid[$i][$j]; 
            echo " $val ";
        }

        echo PHP_EOL; 
    }
}

/**
 * Teste si la valeur peut être ajoutée aux coordonnées demandées
 * @param int $rowIndex Index de ligne
 * @param int $columnIndex Index de colonne
 * @param int $value Valeur
 * @return bool Résultat du test
 */
function isValueValidForPosition(array $grid, int $rowIndex, int $columnIndex, int $value): bool {//jojo
    $bool = false; 
    $column = column($grid, $columnIndex); 
    $ligne = row($grid, $rowIndex);
    $squareIndex = 0;
    if(floor($rowIndex) == 1){//la cellule est deja remplit
        $squareIndex = $squareIndex + 3 + floor($columnIndex/3);
    }if(floor($rowIndex)==2){
        $squareIndex = $squareIndex + 6 + floor($columnIndex/3); 
    }
    $carre = square($grid, $squareIndex);
    if($grid[$rowIndex][$columnIndex] == 0){//val peut etre ajouté
        if(!in_array($value, $column) && !in_array($value, $carre)){
            $bool = true; 
        }
    }
    return $bool; 

}

/**
 * Retourne les coordonnées de la prochaine cellule à partir des coordonnées actuelles
 * (Le parcours est fait de gauche à droite puis de haut en bas)
 * @param int $rowIndex Index de ligne
 * @param int $columnIndex Index de colonne
 * @return array Coordonnées suivantes au format [indexLigne, indexColonne]
 */
function getNextRowColumn(array $grid, int $rowIndex, int $columnIndex): array {//titi
   if ($columnIndex === 8) {
       $columnIndex = 0;
       $rowIndex += 1;
   } else {
       $rowIndex += 1;
   }
    return $nextPosition = [$rowIndex, $columnIndex];
    
}

/**
 * Teste si la grille est valide
 * @return bool
 */
function isValid(array $grid, int $rowIndex, int $columnIndex): bool {//lolo
    $c = $grid[$rowIndex][$columnIndex];
    $xIndex = $rowIndex;
    $yIndex = $columnIndex;
    $rowIndex = 0;
    while ($rowIndex < 9)
    {
        if ($rowIndex != $xIndex) //verif diff de la case pour éviter la boucle inf
            if ($grid[$rowIndex][$columnIndex] == $c)
                return (false);
        $rowIndex++;
    }
    $columnIndex = 0;
    while ($columnIndex < 9)
    {
        if ($columnIndex != $yIndex)// idem avec la colonne
            if ($grid[$xIndex][$columnIndex] == $c)
                return (false);
        $columnIndex++;
    }
   $posY = floor($yIndex / 3) * 3; //verif la carré
    for ($i = 0; $i < 3; $i++)
    {
        $posX = floor($xIndex / 3) * 3; 
        for($j = 0; $j < 3; $j++)
        {
            if ($grid[$posX][$posY] == $c && $posX != $xIndex && $posY != $yIndex)
                return false;
            $posX++;
        }
        $posY++;
    }
    return (true);
}
 

function solve(array &$grid, int $rowIndex, int $columnIndex): ?bool {//jojo
    if ($columnIndex > 8) {//changer de ligne
        ++$rowIndex;
        $columnIndex = 0;
    }
    if ($rowIndex > 8)//fin 
        return true;
    if ($grid[$rowIndex][$columnIndex] != 0)//passer ligne suivante parce quelle est pleine 
        return solve($grid, $rowIndex, $columnIndex + 1);
    while (++$grid[$rowIndex][$columnIndex] < 10) {//incremente la cellule direct
        if (isValid($grid, $rowIndex, $columnIndex)) {//possible ou non de mettre n° dans la case
            if (solve($grid, $rowIndex, $columnIndex + 1)) {//change de cellule
                return true;
            }
        }
    }
   $grid[$rowIndex][$columnIndex] = 0;//pas reussi met 0 dans la case
    return false;
}


$dir = __DIR__ . '/grids';
$files = array_values(array_filter(scandir($dir), function($f){ return $f != '.' && $f != '..'; }));

foreach($files as $file){
    $filepath = realpath($dir . '/' . $file);
    echo("Chargement du fichier $file" . PHP_EOL);
    $grid = loadFromFile($filepath);
    echo(display($grid) . PHP_EOL);
    $startTime = microtime(true);
    echo("Début de la recherche de solution" . PHP_EOL);
    $bool = solve($grid, 0, 0);
    if($bool === false){
        echo("Echec, grille insolvable" . PHP_EOL);
    } else {
        echo("Reussite :" . PHP_EOL);
        echo(display($grid) . PHP_EOL);
    }

    // $duration = round((microtime(true) - $startTime) * 1000);
    // echo("Durée totale : $duration ms" . PHP_EOL);
    // echo("--------------------------------------------------" . PHP_EOL);
}