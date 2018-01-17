package main

import "fmt"

/*
#cgo CFLAGS: -L${SRCDIR}/ -lhi
#cgo CFLAGS: -I../
#include "hi.h" 
*/
import "C"

func main() {
    C.hi()
    fmt.Println("Hi, vim-go")
}
