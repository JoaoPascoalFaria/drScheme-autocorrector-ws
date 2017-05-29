<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exam = "(display (round (* 1000.0 (mede-tempo 1 1))));2;1
        (display (round (* 1000.0 (mede-tempo 10 3))));2;1
        (display (round (* 1000.0 (mede-tempo 11 2.4))));2;1
        (display (round (* 1000.0 (mede-tempo 14 4))));2;1
        (display (round (* 1000.0 (mede-tempo 23 2.34))));2;1
        (display (round (* 1000.0 (mede-tempo-estilo 1 1))));4;2
        (display (round (* 1000.0 (mede-tempo-estilo 13 2))));4;2
        (display (round (* 1000.0 (mede-tempo-estilo 7 3))));4;2
        (display (round (* 1000.0 (mede-tempo-estilo 20 4))));4;2
        (display (round (* 1000.0 (mede-tempo-estilo 12 0))));4;2
        (letrec ((mede-tempo-estilo (lambda (piscinas estilo) (/ (* piscinas 25) (case estilo ((1) 1.5) ((2) 2.0)   ((3) 2.5) (else 3.0))))))(round (* 1000.0 (treino-estilos 3121))));5;3
        (letrec ((mede-tempo-estilo (lambda (piscinas estilo) (/ (* piscinas 25) (case estilo ((1) 1.5) ((2) 2.0)   ((3) 2.5) (else 3.0))))))(round (* 1000.0 (treino-estilos 111111111))));5;3
        (letrec ((mede-tempo-estilo (lambda (piscinas estilo) (/ (* piscinas 25) (case estilo ((1) 1.5) ((2) 2.0)   ((3) 2.5) (else 3.0))))))(round (* 1000.0 (treino-estilos 3122321123221123))));5;3
        (letrec ((mede-tempo-estilo (lambda (piscinas estilo) (/ (* piscinas 25) (case estilo ((1) 1.5) ((2) 2.0)   ((3) 2.5) (else 3.0))))))(round (* 1000.0 (treino-estilos 128456287346287))));5;3
        (letrec ((mede-tempo-estilo (lambda (piscinas estilo) (/ (* piscinas 25) (case estilo ((1) 1.5) ((2) 2.0)   ((3) 2.5) (else 3.0))))))(round (* 1000.0 (treino-estilos 3894628345723))));5;3
        (letrec ((mede-tempo-estilo (lambda (piscinas estilo) (/ (* piscinas 25) (case estilo ((1) 1.5) ((2) 2.0)   ((3) 2.5) (else 3.0))))))(round (* 1000.0 (treino-estilos 23765478235476))));5;3
        (display (round (* 1000.0 (custo-da-viagem 500 1274))));4;4
        (display (round (* 1000.0 (custo-da-viagem 501 1274))));4;4
        (display (round (* 1000.0 (custo-da-viagem 539 1274))));4;4
        (display (round (* 1000.0 (custo-da-viagem 540 1274))));4;4
        (display (round (* 1000.0 (custo-da-viagem 549 1274))));4;4
        (display (altera 28756 11111));4;5
        (display (altera 28756 10101));4;5
        (display (altera 28756 100));4;5
        (display (altera 28756 111111111));4;5
        (display (altera 2875624726358724687485 11010101001010101111));4;5";
        $wording = "{
            \"game_id\": \"1\",
            \"displayed_game_name\": \"Programming\",
            \"lang\": \"en\",
            \"game_description\": \"Coding games for Dr.Scheme\",
            \"user_token\": \"schema_token\",
            \"timeout\": \"60\",
            \"pausable\": \"false\",
            \"accessible\": \"false\",
            \"questions\": [
                {
                    \"question_text\": \"Faça um programa que some a sequência de Fibonacci nas primeiras 10 iterações.\",
                    \"question_image_url\": \"\",
                    \"skippable\": \"\",
                    \"timeout\": \"\",
                    \"lang\": \"scheme\",
                    \"answer_text_template\": \"\"
                },
                {
                    \"question_text\": \"Programa que calcule todos os primos até ao número n.\",
                    \"question_image_url\": \"\",
                    \"skippable\": \"\",
                    \"timeout\": \"\",
                    \"lang\": \"scheme\",
                    \"answer_text_template\": \"(define (isPrimeHelper x k)\n (if (= x k)\n #t \n (if (= (remainder x k) 0)    \n #f     \n (isPrimeHelper x (+ k 1)))))     \n \n (define (printPrimesUpTo n)\n (define result '())\n (define (helper x)\n (if (= x (+ 1 n))\n result                  \n (if (isPrime x)         \n (cons x result) ))         \n ( helper (+ x 1)))\n ( helper 1 ))\"
                }
            ]
        }";
        $solution = ";;;;;;;;;;;;;;
        ; Pergunta 1 ;
        ;;;;;;;;;;;;;;
        ; FEUP Natacinha
        
        ; 1 - 10%
        (define mede-tempo
          (lambda (piscinas velocidade)
            (/ (* piscinas 25) velocidade)))
        
        ; testes
        ;(newline)(display \"Pergunta 1.1:\")(newline)
        ;(mede-tempo 4 2) ; 50
        ;(mede-tempo 1 2.5) ; 10.0
        ;; 5 * 2%
        ;(round (* 1000.0 (mede-tempo 1 1)))
        ;(round (* 1000.0 (mede-tempo 10 3)))
        ;(round (* 1000.0 (mede-tempo 11 2.4)))
        ;(round (* 1000.0 (mede-tempo 14 4)))
        ;(round (* 1000.0 (mede-tempo 23 2.34)))
        
        ; 2. - 20%
        (define mede-tempo-estilo
          (lambda (piscinas estilo)
            (/ (* piscinas 25)
        ; costas 1 1.5
        ; brucos 2 2.0
        ; mariposa 3 2.5
        ; livre - 3.0
               (case estilo
                 ((1) 1.5)
                 ((2) 2.0)
                 ((3) 2.5)
                 (else 3.0)))))
        
        ; testes
        ;(newline)(display \"Pergunta 1.2:\")(newline)
        ;(mede-tempo-estilo 6 1) ; 100.0
        ;(mede-tempo-estilo 6 2) ; 75.0
        ;(mede-tempo-estilo 6 6) ; 50.0
        ;; 5 * 4%
        ;(round (* 1000.0 (mede-tempo-estilo 1 1)))
        ;(round (* 1000.0 (mede-tempo-estilo 13 2)))
        ;(round (* 1000.0 (mede-tempo-estilo 7 3)))
        ;(round (* 1000.0 (mede-tempo-estilo 20 4)))
        ;(round (* 1000.0 (mede-tempo-estilo 12 0)))
        
        
        ; 3 - 30%
        ; agora com recursividade
        (define treino-estilos
          (lambda (treino)
            (if (< treino 10)
                ; caso base
                (mede-tempo-estilo 1 treino)
                ; passo recursivo
                (+ (mede-tempo-estilo 1 (remainder treino 10))
                   (treino-estilos (quotient treino 10))))))
                   
        ; testes
        ;(newline)(display \"Pergunta 1.3:\")(newline)
        ;(treino-estilos 1) ; 16.666666666666668
        ;(treino-estilos 1234) ; 47.5
        ;(treino-estilos 1294803233) ; 105.0
        ;; 6 * 5%
        ;(round (* 1000.0 (treino-estilos 3121)))
        ;(round (* 1000.0 (treino-estilos 111111111)))
        ;(round (* 1000.0 (treino-estilos 3122321123221123)))
        ;(round (* 1000.0 (treino-estilos 1028456287346287)))
        ;(round (* 1000.0 (treino-estilos 3894628345723)))
        ;(round (* 1000.0 (treino-estilos 23765478235476)))
        
        
        ;;;;;;;;;;;;;;
        ; Pergunta 2 ;
        ;;;;;;;;;;;;;;
        ; FEUP Viagens
        
        ; 4 - 20%
        (define custo-da-viagem
          (lambda (estudantes distancia)
            ; 50 - 200 1
            ; 39 - 100 0.9
            (let* ((bus50-completos (quotient estudantes 50))
                   (restantes (remainder estudantes 50))
                   (bus50 (if (> restantes 39) (add1 bus50-completos) bus50-completos))
                   (bus39 (if (> restantes 39) 0 (if (positive? restantes) 1 0))))
              (+ (* bus50 (+ 200 distancia))
                 (* bus39 (+ 180 (* 0.95 distancia)))))))
                 
        
        ; testes
        ;(newline)(display \"Pergunta 2:\")(newline)
        ;(custo-da-viagem 139 100) ; 875 = 2 bus de 50 e 1 bus de 39 = 2*(200+100)+180+0.95*100
        ;(custo-da-viagem 140 100) ; 900
        ;(custo-da-viagem 900 1000) ; 21600
        ;(custo-da-viagem 901 1000) ; 22730
        ;; 5 * 4%
        ;(round (* 1000.0 (custo-da-viagem 500 1274)))
        ;(round (* 1000.0 (custo-da-viagem 501 1274)))
        ;(round (* 1000.0 (custo-da-viagem 539 1274)))
        ;(round (* 1000.0 (custo-da-viagem 540 1274)))
        ;(round (* 1000.0 (custo-da-viagem 549 1274)))
        
        
        ;;;;;;;;;;;;;;
        ; Pergunta 3 ;
        ;;;;;;;;;;;;;;
        
        ; 5 - 20%
        (define altera
          (lambda (numero binario)
            (letrec ((dms
                      (lambda (n)
                        (remainder n 10)))
                     (aux
                      (lambda (n b sobe)
                        ; caso base
                        (if (or (zero? n) (zero? b))
                            n
                            ;caso geral
                            (if (zero? (dms b))
                                ; mantem o mesmo numero
                                (+ (dms n) (* 10 (aux (quotient n 10) (quotient b 10) sobe)))
                                ; altera digito
                                (+ (if sobe
                                    (remainder (add1 (dms n)) 10)
                                    (remainder (sub1 (dms n)) 10))
                                   (* 10 (aux (quotient n 10) (quotient b 10) (not sobe)))))))))
              (aux numero binario #t))))
                                                                       
        ; testes
        ;(newline)(display \"Pergunta 3:\")(newline)
        ;(altera 235 101); 136
        ;(altera 1234567 1101); 136
        ;(altera 1987 101101); 136
        ;; 20% = 5 * 4%
        ;(altera 28756 11111)
        ;(altera 28756 10101)
        ;(altera 28756 100)
        ;(altera 28756 111111111)
        ;(altera 2875624726358724687485 11010101001010101111)
        ";

        DB::table('exams')->insert([
            'name' => "Sample exam",
            'examHash' => hash( "md5", $exam),
            'wordingHash' => hash( "md5", $wording),
            'solutionHash' => hash( "md5", $solution),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('exams')->insert([
            'name' => "Sample no programming exam",
            'examHash' => hash( "md5", ""),
            'wordingHash' => hash( "md5", "Quanto é 1+1? a) 0 b) 1 c) 2 d) 3"),
            'solutionHash' => hash( "md5", "b"),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('evaluations')->insert([
            'user' => "seeder_user",
            'exam' => "1",
            'grade' => "30",
            'submission' => "(define (isPrimeHelper x k)
 (if (= x k)
 #t 
 (if (= (remainder x k) 0)    
 #f     
 (isPrimeHelper x (+ k 1)))))     
 
 (define (printPrimesUpTo n)
 (define result '())
 (define (helper x)
 (if (= x (+ 1 n))
 result                  
 (if (isPrime x)         
 (cons x result) ))         
 ( helper (+ x 1)))
 ( helper 1 ))",
            'timelapse' => "0",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('evaluations')->insert([
            'user' => "seeder_user",
            'exam' => "2",
            'grade' => "100",
            'submission' => "b",
            'timelapse' => "0",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
