// Created by cgo - DO NOT EDIT

//line /home/ubuntu/git/goc2p/src/basic/cgo/lib/rand.go:1
package lib
//line /home/ubuntu/git/goc2p/src/basic/cgo/lib/rand.go:9

//line /home/ubuntu/git/goc2p/src/basic/cgo/lib/rand.go:8
func Random() int {
	return int(_Cfunc_rand())
}
//line /home/ubuntu/git/goc2p/src/basic/cgo/lib/rand.go:13

//line /home/ubuntu/git/goc2p/src/basic/cgo/lib/rand.go:12
func Seed(i int) {
	_Cfunc_srand(_Ctype_uint(i))
}
