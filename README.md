### Setup
```bash
docker-compose build
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan todos:fetch 

```
### Check local server
```bash
http://localhost:8000
```

### Check Database
1. [ ] 1	mock-one_1	mock-one	3	4	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
2. [ ] 2	mock-one_2	mock-one	6	12	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
3. [ ] 3	mock-one_3	mock-one	5	9	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
4. [ ] 4	mock-one_4	mock-one	5	5	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
5. [ ] 5	mock-one_5	mock-one	7	7	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
6. [ ] 6	mock-one_6	mock-one	3	5	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
7. [ ] 7	mock-one_7	mock-one	4	8	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
8. [ ] 8	mock-one_8	mock-one	6	3	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
9. [ ] 9	mock-two_1	mock-two	3	5	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
10. [ ] 10	mock-two_2	mock-two	2	3	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
11. [ ] 11	mock-two_3	mock-two	1	2	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
12. [ ] 12	mock-two_4	mock-two	4	7	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
13. [ ] 13	mock-two_5	mock-two	5	8	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
14. [ ] 14	mock-two_6	mock-two	2	4	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
15. [ ] 15	mock-two_7	mock-two	3	6	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL
16. [ ] 16	mock-two_8	mock-two	1	3	2024-10-08 17:15:34	2024-10-08 17:15:34	NULL

### Algorithm Visualization

![Algorithm Visualization](https://github.com/turgutahmet/todo-app/blob/5cfeee77a02e0291f1a70b980e1dae6be2e2ccf9/algorithm_readme.png)

### Distribution Result

![Distribution Result](https://github.com/turgutahmet/todo-app/blob/4f99f3b3b3ec1606dfd1a5c73e39ee400543c532/distribution.png)
