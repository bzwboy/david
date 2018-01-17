package main

import "fmt"

/*
#cgo CFLAGS: -I./
#cgo LDFLAGS: -L./ -lhi
#include "hi.h" 
*/
import "C"

func main() {
    C.hi()
    fmt.Println("Hi, vim-go")
}
