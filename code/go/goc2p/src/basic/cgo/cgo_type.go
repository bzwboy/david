package main
 
/*
#include <limits.h>
#include <float.h>
 
_Bool b = 1;
char c = 'A';
signed char sc = CHAR_MIN;
unsigned char usc = UCHAR_MAX;
short s = SHRT_MIN;
unsigned short us = USHRT_MAX;
 
int i = INT_MIN;
unsigned int ui = UINT_MAX;
 
long l = LONG_MIN;
unsigned long ul = ULONG_MAX;
 
long long ll = LONG_LONG_MIN;
unsigned long long ull = ULONG_LONG_MAX;
 
float f = FLT_MIN;
double d = DBL_MIN;
long double ld = LDBL_MIN;
 
float _Complex fc = 5+5i;
double _Complex dc = 5+5i;
long double _Complex ldc = 5+5i;
 
__int128_t i128 = 0;
__uint128_t ui128 = 3.4028236692093846346337460743177e+38;
 
void *ptr = 0;
 
*/
import "C"
import "fmt"
import "unsafe"
 
func main() {
    fmt.Println(C.b)
 
    fmt.Println(C.c)
    fmt.Println(C.sc)
    fmt.Println(C.usc)
 
    fmt.Println(C.s)
    fmt.Println(C.us)
 
    fmt.Println(C.i)
    fmt.Println(C.ui)
 
    fmt.Println(C.l)
    fmt.Println(C.ul)
 
    fmt.Println(C.ll)
    fmt.Println(C.ull)
 
    fmt.Println(C.f)
    fmt.Println(C.d)
    //fmt.Println(C.ld)
 
    fmt.Println(C.fc)
    fmt.Println(C.dc)
    //fmt.Println(C.ldc)
 
    fmt.Println(C.i128)
    fmt.Println(C.ui128)
 
    fmt.Println(C.ptr)
 
    fmt.Println("-------------------------------------------------")
    fmt.Println(C._Bool(true))
 
    fmt.Println(C.char('A'))
    fmt.Println(C.schar(-128))
    fmt.Println(C.uchar(255))
 
    fmt.Println(C.short(C.SHRT_MIN))
    fmt.Println(C.ushort(C.USHRT_MAX))
 
    fmt.Println(C.int(C.INT_MIN))
    fmt.Println(C.uint(C.UINT_MAX))
 
    fmt.Println(C.long(C.LONG_MIN))
    fmt.Println(C.ulong(C.ULONG_MAX))
 
    fmt.Println(C.longlong(C.LONG_LONG_MIN))
    fmt.Println(C.ulonglong(18446744073709551615))
 
    fmt.Println(C.float(-1))
    fmt.Println(C.double(-1))
    //fmt.Println(C.longdouble(1))
 
    fmt.Println(C.complexfloat(5 + 5i))
    fmt.Println(C.complexdouble(5 + 5i))
 
    C.i128 = [16]byte{15: 127}
    fmt.Println(C.i128)
 
    C.ui128 = [16]byte{15: 255}
    fmt.Println(C.ui128)
 
    C.ptr = unsafe.Pointer(nil)
    fmt.Println(C.ptr)
 
}
