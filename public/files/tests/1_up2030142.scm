(define mede-tempo
 (lambda (piscinas velocidade)
   (/ (* piscinas 25) velocidade)))

(define mede-tempo-estilo
  (lambda (piscinas estilo)
    (letrec(
            (velocidade1
             (lambda (estilo)
               (cond
                 ((= estilo 1) 1.5)
                 ((= estilo 2) 2.0)
                 ((= estilo 3) 2.5)
                 ((or (> estilo 3)(< estilo 1)) 3))))
            )
      (mede-tempo piscinas (velocidade1 estilo)))))


(define treino-estilos
 (lambda (treino)
   (letrec (
            (dms
             (lambda (n)
               (remainder n 10)))
            (novonum
             (lambda (n)
               (quotient n 10)))
            (aux
             (lambda (n)
               (if (zero? n)
                   0
                   (+ (mede-tempo-estilo 1 (dms n))
                      (aux (novonum n))
                      ))))
            )
     (aux treino))))

(define custo-da-viagem
  (lambda (estudantes distancia)
    (letrec(
            (comboioG
             (lambda (n)
               (quotient n 50)))
            (comboioP
             (lambda (n)
               (ceiling (/ n 39))))
            )
      (if (< (remainder estudantes 50) 40) 
          (begin (+ (* (comboioG estudantes) 200)
                    (* (comboioP (remainder estudantes 50)) 180)
                    (* (comboioG estudantes) 1 distancia)
                    (* (comboioP (remainder estudantes 50)) 0.95 distancia)))
          
          (begin (+ (* (ceiling (/ estudantes 50)) 200)
                    (* (ceiling (/ estudantes 50)) 1 distancia)))))))


(define altera
  (lambda (numero binario)
    (letrec(
            (conta-digitos
             (lambda (n)
               (if (< n 10)
                   1
                   (add1 (conta-digitos (quotient n 10))))))                     
            (dms
             (lambda (n)
               (remainder n 10)))
            (novonum
             (lambda (n)
               (quotient n 10)))
            (aux
             (lambda (numero binario ndigitosb nop)
               (if (zero? ndigitosb)
                   numero
                   (begin
                     (if (= (remainder nop 2) 1)
                         (begin 
                           (if (zero? (dms binario))
                               ;se for 0 imprime o dms numero
                               (begin 
                                 (+ (dms numero)
                                    (* 10 (aux (novonum numero)(novonum binario)(sub1 ndigitosb)nop))))
                                 ;se for 1
                                 (begin 
                                   (+ (add1 (dms numero))
                                      (* 10 (aux (novonum numero)(novonum binario)(sub1 ndigitosb)(add1 nop)))))))
                         (begin 
                           (if (zero? (dms binario))
                               ;se for 0 imprime o dms numero
                               (begin 
                                 (+ (dms numero)
                                    (* 10 (aux (novonum numero)(novonum binario)(sub1 ndigitosb)nop))))
                                 ;se for 1
                                 (begin 
                                   (+ (sub1 (dms numero))
                                      (* 10 (aux (novonum numero)(novonum binario)(sub1 ndigitosb)(add1 nop)))))))))
                     ))))               
            (aux numero (novo-binario numero binario) (conta-digitos binario) 1))))

(define novo-binario
  (lambda (numero binario)
    (if (> (conta-digitos1 binario)(conta-digitos1 numero))
           (remainder binario (expt 10 (conta-digitos1 numero)))
           binario)))
        
  
(define conta-digitos1
             (lambda (n)
               (if (< n 10)
                   1
                   (add1 (conta-digitos1 (quotient n 10))))))