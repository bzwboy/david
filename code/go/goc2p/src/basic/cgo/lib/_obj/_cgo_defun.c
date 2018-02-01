
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

#pragma cgo_import_static _cgo_9e15829dd244_Cfunc_rand
void _cgo_9e15829dd244_Cfunc_rand(void*);

void
·_Cfunc_rand(struct{void *y[1];}p)
{
	runtime·cgocall(_cgo_9e15829dd244_Cfunc_rand, &p);
}

#pragma cgo_import_static _cgo_9e15829dd244_Cfunc_srand
void _cgo_9e15829dd244_Cfunc_srand(void*);

void
·_Cfunc_srand(struct{void *y[1];}p)
{
	runtime·cgocall(_cgo_9e15829dd244_Cfunc_srand, &p);
}

