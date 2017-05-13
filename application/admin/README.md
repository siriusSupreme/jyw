关联模型
===============

## 一对一关联

~~~

+----------------------------------------------------------+
+   数据表    主键    外键     备注
+   user      uid            主表
+   profile   pid    f_uid   副表
+----------------------------------------------------------+
一个用户(user)有一份简介(profile)
class User extends Model
{
    public function profile()
    {
        return $this->hasOne('Profile','f_uid','uid');
    }
}

一份简介(profile)属于一个用户(user)
class Profile extends Model 
{
    public function user()
    {
        return $this->belongsTo('User','f_uid','uid');
    }
}

~~~

## 一对多关联

~~~

+----------------------------------------------------------+
+   数据表    主键    外键     备注
+   article   aid            主表
+   comment   cid    f_aid   副表
+----------------------------------------------------------+
一篇文章(article)有多个评论(comment)
class Article extends Model
{
    public function profile()
    {
        return $this->hasMany('Comment','f_aid','aid');
    }
}

多个评论(comment)属于一篇文章(article)
class Comment extends Model 
{
    public function user()
    {
        return $this->belongsTo('Article','f_aid','aid');
    }
}

~~~

## 远程一对多关联

~~~

+----------------------------------------------------------+
+   数据表     主键    外键            备注
+   city      cid                    城市表
+   user      uid    f_cid           用户表
+   tu_middle tuid   ff_uid,ff_tid   用户和话题中间表
+   topic     tid    f_uid           话题表
+----------------------------------------------------------+
一个城市(city)有多个用户(user)
一个城市(city)有多个话题(topic)
class City extends Model
{
    public function user()
    {
        return $this->hasMany('User','f_cid','cid');
    }
    public function topic()
    {
        return $this->hasManyThrough('Topic','User','f_cid','f_uid','tid');
    }
}

一个用户(user)属于一个城市(city)
一个用户(user)有多个话题(topic)
class User extends Model
{
    public function city()
    {
        return $this->belongsTo('City','f_cid','cid');
    }
    public function topic()
    {
        return $this->belongsToMany('Topic','tu_middle','ff_tid','ff_uid');
    }
}

一个话题(topic)属于多个用户(user)
class Topic extends Model
{
    public function user()
    {
        return $this->belongsToMany('User','tu_middle','ff_uid','ff_tid');
    }
}


~~~

## 多态一对多关联

~~~

+----------------------------------------------------------+
+   数据表    主键    外键     区分字段        备注
+   article  aid                            文章表
+   book     bid                            书籍表
+   comment  cid             c_type,c_id    评论表
+----------------------------------------------------------+
一个内容(article或者book)有多个评论(comment)
class Article extends Model
{
    public function comment()
    {
        return $this->morphMany('Comment','c','article');
    }
}

class Book extends Model
{
    public function comment()
    {
        return $this->morphMany('Comment','c','book');
    }
}

多个评论(comment)属于一个内容(article或者book)
class Comment extends Model 
{
    public function content()
    {
        return $this->morphTo('c',['article'=>'app\admin\model\Article','book'=>'app\admin\model\Book']);
    }
}

~~~

## 多态一对一关联

~~~

+----------------------------------------------------------+
+   数据表    主键    外键     区分字段        备注
+   admin    aid                            管理员表
+   member   mid                            会员表
+   profile  pid             p_type,p_id    简介表
+----------------------------------------------------------+
一个用户(admin或者member)有一份简介(profile)
class Admin extends Model
{
    public function profile()
    {
        return $this->morphOne('Profile','p','admin');
    }
}

class Member extends Model
{
    public function profile()
    {
        return $this->morphOne('Profile','p','member');
    }
}

一份简介(profile)属于一个用户(admin或者member)
class Profile extends Model 
{
    public function user()
    {
        return $this->morphTo('p',['admin'=>'app\admin\model\Admin','member'=>'app\admin\model\Member']);
    }
}

~~~

## 多对多关联

~~~

+----------------------------------------------------------+
+   数据表    主键    外键         备注
+   user     uid                 用户表
+   middle   mid    f_uid,f_rid  中间表
+   role     rid                 角色表
+----------------------------------------------------------+
一个用户(user)属于多个角色(role)
class User extends Model
{
    public function profile()
    {
        return $this->belongsToMany('Role','middle','f_rid','f_uid');
    }
}

一个角色(role)拥有多个用户(user)
class Role extends Model 
{
    public function user()
    {
        return $this->belongsToMany('User','middle','f_uid','f_rid');
    }
}

~~~


更多细节参阅 [LICENSE.txt](LICENSE.txt)
"# jyw" 
