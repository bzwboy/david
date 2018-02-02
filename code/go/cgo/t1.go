package main

import (
        "fmt"
        "unsafe"
       )

/*
extern void go_callback_int(void*, int);
static inline void CallMyFunction(void* pfoo) {
   go_callback_int(pfoo, 5);
}
 */
import "C"

//export go_callback_int
func go_callback_int(pfoo unsafe.Pointer, p1 C.int) {
    foo := (*Test)(pfoo)
    foo.cb(p1)
}

type Test struct {
}

func (s *Test) cb(x C.int) {
    fmt.Println("callback with", x)
}

// 复制结构体指针传递给C 函数
// C 函数调用Go 函数，再传递指针给Go 函数
// Go 函数转换C 传递的指针，然后调用
func main() {
    data := &Test{}
    C.CallMyFunction(unsafe.Pointer(&data))
}
