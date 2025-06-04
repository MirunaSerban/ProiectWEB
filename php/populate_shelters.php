<?php
require_once 'conectare.php';

// Ștergem toate înregistrările existente, dezactivând temporar verificarea cheilor străine
try {
    // Dezactivăm temporar foreign key checks
    $conn->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    // Ștergem datele existente
    $conn->exec("TRUNCATE TABLE adaposturi");
    
    // Reactivăm foreign key checks
    $conn->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "Curățare completă!\n";
} catch(PDOException $e) {
    echo "Eroare la ștergerea datelor existente: " . $e->getMessage() . "\n";
    exit;
}

// Array cu adăposturile din fiecare județ
$adaposturi = [
    'Cluj' => [
        [
            'nume' => 'Centrul de Gestionare a Câinilor fără Stăpân Cluj-Napoca',
            'oras' => 'Cluj-Napoca',
            'adresa' => 'Str. Bobâlnei, FN',
            'telefon' => '0264 450 286',
            'email' => 'adapostcaini@primariaclujnapoca.ro',
            'website' => 'https://www.primariaclujnapoca.ro'
        ],
        [
            'nume' => 'Asociația Prietenii Animalelor Cluj',
            'oras' => 'Cluj-Napoca',
            'adresa' => 'Str. Făget, nr. 1',
            'telefon' => '0742 511 977',
            'email' => 'contact@prieteniianimalelor.ro',
            'website' => 'https://www.prieteniianimalelor.ro'
        ]
    ],
    'Harghita' => [
        [
            'nume' => 'Fundația Pro Animalia',
            'oras' => 'Miercurea Ciuc',
            'adresa' => 'DN12A nr. 138D',
            'telefon' => '0749 416 802',
            'email' => 'proanimaliaoffice@gmail.com',
            'website' => 'https://ro-ro.facebook.com/proanimaliahr/'
        ],
        [
            'nume' => 'Adăpost CFS Toplița',
            'oras' => 'Toplița',
            'adresa' => 'Strada Sportivilor, nr. 50',
            'telefon' => '0741 111 839',
            'email' => null,
            'website' => 'https://primariatoplita.ro/adapost-caini/'
        ]
    ],
    'București' => [
        [
            'nume' => 'ASPA București - Adăpostul Bragadiru',
            'oras' => 'București',
            'adresa' => 'Șoseaua Bragadiru-Mihăilești nr. 247, Bragadiru, Ilfov',
            'telefon' => '021 312 95 55',
            'email' => 'office@aspa.ro',
            'website' => 'https://aspa.ro'
        ],
        [
            'nume' => 'Asociația SOS Dogs',
            'oras' => 'București',
            'adresa' => 'Str. Intrarea Vagonetului nr. 2, Sector 6',
            'telefon' => '0722 555 672',
            'email' => 'contact@sosdogs.ro',
            'website' => 'https://sosdogs.ro'
        ]
    ],
    'Brașov' => [
        [
            'nume' => 'Adăpostul Stupini',
            'oras' => 'Brașov',
            'adresa' => 'Str. Cărămidăriei nr. 1, Stupini',
            'telefon' => '0268 472 369',
            'email' => 'adapost@brasovcity.ro',
            'website' => 'https://www.brasovcity.ro'
        ],
        [
            'nume' => 'Asociația Milioane de Prieteni',
            'oras' => 'Brașov',
            'adresa' => 'Str. Zizinului nr. 130',
            'telefon' => '0268 333 164',
            'email' => 'office@millionsoffriends.org',
            'website' => 'https://millionsoffriends.org'
        ]
    ],
    'Constanța' => [
        [
            'nume' => 'Adăpostul Public Constanța',
            'oras' => 'Constanța',
            'adresa' => 'Str. Câmpul cu Flori nr. 15',
            'telefon' => '0241 488 000',
            'email' => 'adapost@primaria-constanta.ro',
            'website' => 'https://www.primaria-constanta.ro'
        ],
        [
            'nume' => 'Asociația Pet Hope',
            'oras' => 'Constanța',
            'adresa' => 'Str. Dezrobirii nr. 123',
            'telefon' => '0725 555 777',
            'email' => 'contact@pethope.ro',
            'website' => 'https://pethope.ro'
        ]
    ],
    'Timiș' => [
        [
            'nume' => 'DANYFLOR Timișoara',
            'oras' => 'Timișoara',
            'adresa' => 'Calea Șagului DN 59 KM 3+300 dreapta',
            'telefon' => '0256 246 100',
            'email' => 'office@danyflor.ro',
            'website' => 'https://danyflor.ro'
        ],
        [
            'nume' => 'Asociația pentru Protecția Animalelor Timișoara',
            'oras' => 'Timișoara',
            'adresa' => 'Str. Gheorghe Lazăr nr. 7',
            'telefon' => '0356 424 394',
            'email' => 'contact@apat.ro',
            'website' => 'https://apat.ro'
        ]
    ],
    'Iași' => [
        [
            'nume' => 'Adăpostul Public Iași',
            'oras' => 'Iași',
            'adresa' => 'Șos. Tudor Neculai nr. 25',
            'telefon' => '0232 267 085',
            'email' => 'adapost@primaria-iasi.ro',
            'website' => 'https://www.primaria-iasi.ro'
        ],
        [
            'nume' => 'Asociația Red Panda',
            'oras' => 'Iași',
            'adresa' => 'Str. Păcurari nr. 156',
            'telefon' => '0747 888 999',
            'email' => 'contact@redpanda.ro',
            'website' => 'https://redpanda.ro'
        ]
    ],
    'Sibiu' => [
        [
            'nume' => 'Adăpostul Public Sibiu',
            'oras' => 'Sibiu',
            'adresa' => 'Str. Podului nr. 10',
            'telefon' => '0269 208 990',
            'email' => 'adapost@sibiu.ro',
            'website' => 'https://www.sibiu.ro'
        ],
        [
            'nume' => 'Asociația ARCA LUI NOE Sibiu',
            'oras' => 'Sibiu',
            'adresa' => 'Str. Calea Șurii Mici nr. 31',
            'telefon' => '0745 521 522',
            'email' => 'contact@arcaluinoe.ro',
            'website' => 'https://www.arcaluinoe.ro'
        ]
    ],
    'Mureș' => [
        [
            'nume' => 'Adăpostul Târgu Mureș',
            'oras' => 'Târgu Mureș',
            'adresa' => 'Str. Libertății nr. 50',
            'telefon' => '0265 266 199',
            'email' => 'adapost@tirgumures.ro',
            'website' => 'https://www.tirgumures.ro'
        ],
        [
            'nume' => 'Asociația Save & Smile',
            'oras' => 'Târgu Mureș',
            'adresa' => 'Str. Gheorghe Doja nr. 193',
            'telefon' => '0742 146 785',
            'email' => 'contact@saveandsmile.ro',
            'website' => 'https://www.saveandsmile.ro'
        ]
    ],
    'Bihor' => [
        [
            'nume' => 'Centrul de Gestionare a Câinilor Oradea',
            'oras' => 'Oradea',
            'adresa' => 'Str. Matei Corvin nr. 21',
            'telefon' => '0259 411 733',
            'email' => 'adapost@oradea.ro',
            'website' => 'https://www.oradea.ro'
        ],
        [
            'nume' => 'Asociația SOS Animals Bihor',
            'oras' => 'Oradea',
            'adresa' => 'Str. Universității nr. 15',
            'telefon' => '0744 999 789',
            'email' => 'contact@sosanimals.ro',
            'website' => 'https://www.sosanimalsbihor.ro'
        ]
    ],
    'Maramureș' => [
        [
            'nume' => 'Adăpostul Municipal Baia Mare',
            'oras' => 'Baia Mare',
            'adresa' => 'Str. Victoriei nr. 154',
            'telefon' => '0262 211 924',
            'email' => 'adapost@baiamare.ro',
            'website' => 'https://www.baiamare.ro'
        ],
        [
            'nume' => 'Asociația Hope for Animals',
            'oras' => 'Baia Mare',
            'adresa' => 'Str. Luminișului nr. 7',
            'telefon' => '0745 112 233',
            'email' => 'contact@hopeforanimals.ro',
            'website' => 'https://www.hopeforanimals.ro'
        ]
    ],
    'Suceava' => [
        [
            'nume' => 'Adăpostul Public Suceava',
            'oras' => 'Suceava',
            'adresa' => 'Str. Energeticianului nr. 11',
            'telefon' => '0230 524 128',
            'email' => 'adapost@primariasv.ro',
            'website' => 'https://www.primariasv.ro'
        ],
        [
            'nume' => 'Asociația Salvați Animalele Suceava',
            'oras' => 'Suceava',
            'adresa' => 'Str. Mărășești nr. 33',
            'telefon' => '0744 556 677',
            'email' => 'contact@salvatianimalelesv.ro',
            'website' => 'https://www.salvatianimalelesv.ro'
        ]
    ],
    'Bacău' => [
        [
            'nume' => 'Adăpostul Municipal Bacău',
            'oras' => 'Bacău',
            'adresa' => 'Str. Izvoare nr. 101',
            'telefon' => '0234 205 300',
            'email' => 'adapost@primariabacau.ro',
            'website' => 'https://www.primariabacau.ro'
        ],
        [
            'nume' => 'Asociația Animal Life Bacău',
            'oras' => 'Bacău',
            'adresa' => 'Str. Mioriței nr. 21',
            'telefon' => '0747 123 456',
            'email' => 'contact@animallife.ro',
            'website' => 'https://www.animallifebacau.ro'
        ]
    ],
    'Galați' => [
        [
            'nume' => 'Adăpostul Public Galați',
            'oras' => 'Galați',
            'adresa' => 'Str. Traian nr. 254',
            'telefon' => '0236 411 277',
            'email' => 'adapost@primariagalati.ro',
            'website' => 'https://www.primariagalati.ro'
        ],
        [
            'nume' => 'Asociația Animal Shield Galați',
            'oras' => 'Galați',
            'adresa' => 'Str. Brăilei nr. 156',
            'telefon' => '0743 211 233',
            'email' => 'contact@animalshield.ro',
            'website' => 'https://www.animalshield.ro'
        ]
    ],
    'Dolj' => [
        [
            'nume' => 'Adăpostul Salubritate Craiova',
            'oras' => 'Craiova',
            'adresa' => 'Str. Brestei nr. 129A',
            'telefon' => '0251 411 214',
            'email' => 'adapost@salubritate.ro',
            'website' => 'https://www.salubritate.ro'
        ],
        [
            'nume' => 'Asociația Pet Rescue Dolj',
            'oras' => 'Craiova',
            'adresa' => 'Str. Nicolae Titulescu nr. 87',
            'telefon' => '0745 987 654',
            'email' => 'contact@petrescue.ro',
            'website' => 'https://www.petrescuedolj.ro'
        ]
    ],
    'Argeș' => [
        [
            'nume' => 'Adăpostul Municipal Pitești',
            'oras' => 'Pitești',
            'adresa' => 'Str. Depozitelor nr. 33',
            'telefon' => '0248 223 299',
            'email' => 'adapost@primariapitesti.ro',
            'website' => 'https://www.primariapitesti.ro'
        ],
        [
            'nume' => 'Asociația Animal Care Argeș',
            'oras' => 'Pitești',
            'adresa' => 'Str. Exercițiu nr. 99',
            'telefon' => '0747 445 566',
            'email' => 'contact@animalcare.ro',
            'website' => 'https://www.animalcareag.ro'
        ]
    ],
    'Prahova' => [
        [
            'nume' => 'Adăpostul Public Ploiești',
            'oras' => 'Ploiești',
            'adresa' => 'Str. Corlătești nr. 11',
            'telefon' => '0244 515 937',
            'email' => 'adapost@ploiesti.ro',
            'website' => 'https://www.ploiesti.ro'
        ],
        [
            'nume' => 'Asociația Animal Life Prahova',
            'oras' => 'Ploiești',
            'adresa' => 'Str. Gheorghe Doja nr. 112',
            'telefon' => '0744 332 211',
            'email' => 'contact@animallifeph.ro',
            'website' => 'https://www.animallifeprahova.ro'
        ]
    ]
];

try {
    // Pregătim query-ul de inserare
    $stmt = $conn->prepare("
        INSERT INTO adaposturi (nume, judet, oras, adresa, telefon, email, website) 
        VALUES (:nume, :judet, :oras, :adresa, :telefon, :email, :website)
    ");

    echo "Începem inserarea adăposturilor...\n";
    $count = 0;
    
    // Inserăm datele pentru fiecare județ
    foreach ($adaposturi as $judet => $lista_adaposturi) {
        echo "\nInserare adăposturi pentru județul: " . $judet . "\n";
        foreach ($lista_adaposturi as $adapost) {
            $stmt->execute([
                ':nume' => $adapost['nume'],
                ':judet' => $judet,
                ':oras' => $adapost['oras'],
                ':adresa' => $adapost['adresa'],
                ':telefon' => $adapost['telefon'],
                ':email' => $adapost['email'] ?? null,
                ':website' => $adapost['website'] ?? null
            ]);
            $count++;
            echo "  - Adăugat: " . $adapost['nume'] . "\n";
        }
    }

    echo "\nAdăposturile au fost adăugate cu succes! Total: " . $count . " adăposturi.\n";

} catch(PDOException $e) {
    echo "Eroare la adăugarea adăposturilor: " . $e->getMessage() . "\n";
} 