package main

/*
#cgo CFLAGS: -I../
#cgo LDFLAGS: -L../ -lmyhello
#include "hello.h"
*/
import "C"

func main() {
    str := C.CString("libo");
    C.hello(str)
}
