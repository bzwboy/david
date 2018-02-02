package main

/*
#cgo LDFLAGS: -L. -lbar
#cgo CFLAGS: -I.
#include "bar.h"
*/
import "C"
import "fmt"

func main() {
    fmt.Println(int(C.callback()))
    // Output: 42
}

func FuncMain() {
    fmt.Println("FuncMain called in main.go")
}
