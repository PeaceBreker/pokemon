# RESTFUL API

## pokemon

- Pokemon store
- Pokemon index
- Pokemon show
- Pokemon update
- Pokemon destroy

## Nature

- Nature store
- Nature index
- Nature update

## Race

- Get race by name
- Race show
- Race index
- Get skills by race

## Ability

- Ability store
- Ability index
- Ability update

## Skill

- Skill store
- Skill index
- Skill update

## Auth

- Register
- Login
- Logout
- Get friendship by user

## Friendship

- Send friend request
- Accept friend request
- Reject friend request
- Remove friend

# Pokemon

- 新增時強制進化

## Pokemon store

## POST method

### path：/api/pokemons

### Header：(Accept : application/json)

### Validate

```php
'name' => 'required|max:20',
'level' => 'required|integer|between:1,100',
'nature_id' => 'required|max:20|exists:natures,id',
'race_id' => 'required|max:20|exists:races,id',
'ability_id' => 'required|max:20|exists:abilities,id',
'skill' => ['required', 'array', 'between:1,4', new SkillValidator]
```

### Response

```php
status code(201)

status code(400)

status code(422)

status code(404)

```

## Pokemon index

## GET method

### path：/api/pokemons

### Header：無

### Response

```php
status code(200)
```

## Pokemon show

## GET method

### path：api/pokemons/{id}

### Header：無

### Response

```php
status code(200)

status code(404)
```

## Pokemon update

## PUT method

### path：api/pokemons/{id}

### Header：(Accept : application/json)

### Validate

```php
'name' => 'sometimes|required|max:20',
'level' => 'sometimes|required|integer|max:100',
'nature_id' => 'sometimes|required|max:20|exists:natures,id',
'race_id' => 'sometimes|required|max:20|exists:race,id',
'ability_id' => 'sometimes|required|max:20|exists:abilities,id',
'skill' => 'sometimes|required|array|between:1,4'
```

### Response

```php
status code(200)

status code(404)
```

## Pokemon destroy

## DELETE method

### path：/api/pokemons/{id}

### Header：無

### Response

# Nature

- 匯入資料

## Nature store

## POST method

### path：/api/natures

### Header：(Accept : application/json)

### Validate

```php
'name' => 'required|max:20|unique:natures',
```

### Response

```php
status code(201)

status code(422)

status code(422)
```

## Nature index

## GET method

### path：/api/natures

### Response

```php
status code(200)

```

## Nature update

## PUT method

### path：/api/natures/{id}

### Header：(Accept : application/json)

### Validate

```php
'name' => 'required|max:20|unique:natures',
```

### Response

```php
status code(200)

status code(422)
```

# Race

- 匯入官網資料(artisan指令)

## Get race by name

## GET method

### path：/api/races/{name}

### Response

```php
status code(200)

status code(500)
```

## Race index

## GET method

### path：/api/races

### Response

```php
status code(200)
```

## Get skills by race

## GET method

### path：/api/races/{id}/skills

### Response

```php
status code(200)

status code(404)
```

# Ability

- 匯入資料

## Ability store

## POST method

### path：/api/abilities

### Header：(Accept : application/json)

### Validate

```php
'name' => 'required|string|max:20|unique:abilities',
```

### Response

```php
status code(201)

status code(422)

status code(422)
```

## Ability index

## GET method

### path：/api/abilities

### Response

```php
status code(200)
```

## Ability update

## PUT method

### path：/api/abilities/{id}

### Header：(Accept : application/json)

### Validate

```php
'name' => 'required|string|max:20|unique:abilities',
```

### Response

```php
status code(200)

status code(500)
```

# Skill

- 匯入官網資料(artisan指令)

## Skill store

## POST method

### path：/api/skills

### Header：(Accept : application/json)

### Validate

```php
'name' => 'required|unique:skills|max:20',
```

### Response

```php
status code(201)

status code(422)

status code(422)
```

## Skill index

## GET  method

### path：/api/skills

### Response

```php
status code(200)
```

## Skill update

## PUT method

### path：/api/skills/{id}

### Header：(Accept : application/json)

### Validate

```php
'name' => 'required|unique:skills|max:20',
```

### Response

```php
status code(200)

status code(422)

status code(422)

status code(404)
```

# Auth

## Register

## POST method

### path：/api/register

### Header：(Accept : application/json)

### Validate

```php
'name' => [
            'required',
            'unique:users,name',
            'string',
            'not_regex:/[!@#$%^&*(),.?":{}|<>]/'
            ],
            'email' => 'required|email|unique:users,email',
            'password' => [
            'required',
            'string',
            'min:6',
            'regex:/^[A-Z][a-zA-Z0-9]*$/',
            'not_regex:/[!@#$%^&*(),.?":{}|<>]/'
            ]
```

### Response

```php
status code(201)

status code(400)
```

## Login

## POST method

### path：/api/login

### Header：(Accept : application/json)

### Validate

```php
'name' => [
            'required',
            'string',
            'not_regex:/[!@#$%^&*(),.?":{}|<>]/'
            ],
            'email' => 'required|email',
            'password' => [
            'required',
            'string',
            'min:6',
            'regex:/^[A-Z][a-zA-Z0-9]*$/',
            'not_regex:/[!@#$%^&*(),.?":{}|<>]/'
            ]
```

### Response

```php
status code(200)

status code(401)
```

## Logout

## GET method

### path：/api/logout

### Header：無

### Response

```php
status code(200)

status code(403)
```

## Get friendship by user

## GET method

### path：/api/get-friends

### Header：無

### Response

```php
status code(200)
```

# Friendship

## Send friend request

### POST method

### path：/api/send-friend-request/{recipient}

### Header：無

### Response

```php
status code(200)

status code(400)

status code(400)
```

## Accept friend request

### POST method

### path：/api/accept-friend-request/{friendship}

### Header：無

### Validate

```php
'friendship_id' => 'required|exists:friendships,id',
```

### Response

```php
status code(200)
```

## Reject friend request

### POST method

### path：/api/rejectFriendRequest/{friendshipId}

### Header：無

### Validate

```php
'friendship_id' => 'required|exists:friendships,id',
```

### Response

```php
status code(200)

status code(400)
```

## Remove friend

### DELETE method

### path：/api/remove-friend/{friend}

### Header：無

### Response

```php
status code(204)

status code(404)
```