import re, sys, pathlib
from html.parser import HTMLParser
VOID = {'img','br','hr','input','meta','link','source','area','base','col','embed','track','wbr'}
root = pathlib.Path(sys.argv[1])
bad = 0
class P(HTMLParser):
    def __init__(s):
        super().__init__(convert_charrefs=True); s.stack = []; s.err = []
    def handle_starttag(s, t, a):
        if t not in VOID: s.stack.append((t, s.getpos()))
    def handle_startendtag(s, t, a): pass
    def handle_endtag(s, t):
        if t in VOID: return
        if not s.stack or s.stack[-1][0] != t:
            s.err.append('unexpected </%s> at %s (open: %s)' % (t, s.getpos(), s.stack[-1] if s.stack else None))
        else: s.stack.pop()
for d in ('templates', 'parts', 'patterns'):
    for f in sorted(p for p in (root / d).iterdir() if p.suffix in ('.html', '.php')):
        t = f.read_text(encoding='utf8')
        t = re.sub(r'<\?php.*?\?>', 'X', t, flags=re.S)
        errs = []
        st = []
        for m in re.finditer(r'<!--\s+(/?)wp:([a-z0-9/-]+)(?:\s+\{.*?\})?\s*(/?)-->', t, re.S):
            close, name, selfc = m.group(1), m.group(2), m.group(3)
            if selfc: continue
            if close:
                if not st or st[-1] != name: errs.append('block close %s vs %s' % (name, st[-1] if st else None))
                else: st.pop()
            else: st.append(name)
        if st: errs.append('unclosed blocks %s' % st)
        p = P(); p.feed(t)
        errs += p.err
        if p.stack: errs.append('unclosed tags %s' % p.stack)
        leftover = [c for c in re.findall(r'<!--(.*?)-->', t, re.S) if not c.strip().startswith(('wp:', '/wp:'))]
        if leftover: errs.append('non-block comments: %d' % len(leftover))
        if errs:
            bad += 1; print(d, f.name, errs)
print('checked; files with problems:', bad)
