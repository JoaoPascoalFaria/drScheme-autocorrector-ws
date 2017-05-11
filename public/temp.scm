(define (isPrimeHelper x k)
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
( helper 1 ))