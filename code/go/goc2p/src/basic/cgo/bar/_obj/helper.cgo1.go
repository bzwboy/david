// Created by cgo - DO NOT EDIT

//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar/helper.go:1
package main
//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar/helper.go:5

//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar/helper.go:4
import "fmt"
//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar/helper.go:8

//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar/helper.go:7
func GoFunc() int {
	fmt.Println("GoFunc called in helper.go")
	FuncHelper()
	FuncMain()
	return 42
}
//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar/helper.go:15

//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar/helper.go:14
func FuncHelper() {
	fmt.Println("FuncHelper called in helper.go")
}
