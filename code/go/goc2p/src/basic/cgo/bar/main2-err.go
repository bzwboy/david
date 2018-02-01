package main

/*
# command-line-arguments
In file included from $WORK/command-line-arguments/_obj/_cgo_export.c:2:0:
./main2-err.go:33:14: error: conflicting types for ‘Fortytwo’
In file included from ./main2-err.go:6:0,
                 from $WORK/command-line-arguments/_obj/_cgo_export.c:2:
./bar.h:1:12: note: previous declaration of ‘Fortytwo’ was here
 extern int Fortytwo();
            ^
/tmp/go-build326015800/command-line-arguments/_obj/_cgo_export.c:8:7: error: conflicting types for ‘Fortytwo’
 GoInt Fortytwo()
       ^
In file included from ./main2-err.go:6:0,
                 from $WORK/command-line-arguments/_obj/_cgo_export.c:2:
./bar.h:1:12: note: previous declaration of ‘Fortytwo’ was here
 extern int Fortytwo();
            ^ 
*/

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

//export Fortytwo
func Fortytwo() int {
    return 42
}
