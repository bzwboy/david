
#include "runtime.h"
#include "cgocall.h"

void ·_Cerrno(void*, int32);

void
·_Cfunc_GoString(int8 *p, String s)
{
	s = runtime·gostring((byte*)p);
	FLUSH(&s);
}

void
·_Cfunc_GoStringN(int8 *p, int32 l, String s)
{
	s = runtime·gostringn((byte*)p, l);
	FLUSH(&s);
}

void
·_Cfunc_GoBytes(int8 *p, int32 l, Slice s)
{
	s = runtime·gobytes((byte*)p, l);
	FLUSH(&s);
}

void
·_Cfunc_CString(String s, int8 *p)
{
	p = runtime·cmalloc(s.len+1);
	runtime·memmove((byte*)p, s.str, s.len);
	p[s.len] = 0;
	FLUSH(&p);
}

void
·_Cfunc__CMalloc(uintptr n, int8 *p)
{
	p = runtime·cmalloc(n);
	FLUSH(&p);
}

#pragma cgo_import_static _cgo_87b9922e1d1d_Cfunc_callback
void _cgo_87b9922e1d1d_Cfunc_callback(void*);

void
·_Cfunc_callback(struct{void *y[1];}p)
{
	runtime·cgocall(_cgo_87b9922e1d1d_Cfunc_callback, &p);
}

#pragma cgo_export_dynamic GoFunc
extern void ·GoFunc();

#pragma cgo_export_static _cgoexp_87b9922e1d1d_GoFunc
#pragma textflag 7
void
_cgoexp_87b9922e1d1d_GoFunc(void *a, int32 n)
{
	runtime·cgocallback(·GoFunc, a, n);
}
