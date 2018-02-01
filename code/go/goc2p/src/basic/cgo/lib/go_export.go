package lib

/*
#include <stdio.h>
extern void CFunction1();
*/
import "C"

import (
        "fmt"
       )

//export GoFunction1
func GoFunction1(cs *C.char, cd C.int, cf C.float) {
    s := C.GoString(cs)
    d := int(cd)
    f := float32(cf)

	fmt.Println("GoFunction1() is called.\n")
    fmt.Printf("string:%s\nint:%d\nfloat:%f\n", s, d, f)
    fmt.Println(cf)
}

func CallCFunc() {
	C.CFunction1()
}
