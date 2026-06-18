-- https://dev.mysql.com/doc/refman/9.7/en/create-procedure.html

CREATE LIBRARY IF NOT EXISTS jslib.lib1 LANGUAGE JAVASCRIPT
    AS $$
      export function f(n) {
        return n
      }
    $$;

CREATE LIBRARY IF NOT EXISTS jslib.lib2 LANGUAGE JAVASCRIPT
    AS $$
      export function g(n) {
        return n * 2
      }
    $$;

CREATE FUNCTION foo(n INTEGER) RETURNS INTEGER LANGUAGE JAVASCRIPT
    USING (jslib.lib1 AS mylib, jslib.lib2 AS yourlib)
    AS $$
      return mylib.f(n) + yourlib.g(n)
    $$;

-- https://medium.com/@vbilopav/why-i-rely-on-postgresql-functions-for-everything-pros-cons-and-best-practice-article-review-987eba321234

create or replace function todo.get_item_title(
    _id bigint
)
returns text
language sql
as 
$$
select title from todo.my_items where id = _id
$$;

create or replace function todo.get_item_title(
    _id bigint,
    _user_id bigint
)
returns text
language sql
begin atomic

-- log action
insert into todo.logs (user_id, action)
values (_user_id, 'get_item_title');

-- retrive title
select title from todo.items where id = id;
end;

create or replace function public.print_record(
    _record record
)
returns void
language plpgsql
as
$$
begin
    raise info '%', _record;
end;
$$;

select 
    id, 
    title, 
    print_record(todo.items.*) -- print out the conetext of the record
from todo.items;

