package main

import "C"
import "fmt"

//export GoFunc
func GoFunc() int {
    fmt.Println("GoFunc called in helper.go")    
    FuncHelper()
    FuncMain()
    return 42
}

func FuncHelper() {
    fmt.Println("FuncHelper called in helper.go")
}
