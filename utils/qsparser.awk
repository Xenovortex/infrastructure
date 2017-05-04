#!/usr/bin/awk -f
BEGIN{
    FS="?"
}
{
    sub(/.*[/]/,"",$1)
    if ($1 ~ api) {
        n=split($2,b,/&/)
        for (i=1;i<=n;i++)
            if (match(b[i], qsparam)) print b[i]
    }
}
