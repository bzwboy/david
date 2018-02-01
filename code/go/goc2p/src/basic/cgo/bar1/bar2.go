// bar2.go

package main

/*
extern int Fortytwo();

typedef int (*intFunc) ();

int bridge_int_func(intFunc f)
{
    return f();
}

int callback()
{
    return bridge_int_func(Fortytwo);
}
*/
import "C"
import "fmt"

func main() {
    fmt.Println(int(C.callback()))
    // Output: 42
}

