<?php
const MAIN_DIRECTORY = '/beejee/';
const TASKS_PER_PAGE = 3;
const MIN_LENGTH_NAME = 4;
const MAX_LENGTH_NAME = 30;
const MIN_LENGTH_TASK_TEXT = 10;
const MAX_LENGTH_TASK_TEXT = 1000;
const MAX_PAGES_IN_PAGER = 8;

//Popup messages

const MESSAGE_ERROR_NAME = 'Длина имени должна быть от ' . MIN_LENGTH_NAME . ' до ' . MAX_LENGTH_NAME . ' символов';
const MESSAGE_ERROR_EMAIL = 'Введите корректный email';
const MESSAGE_ERROR_TASK_TEXT = 'Длина задачи должна быть от ' . MIN_LENGTH_TASK_TEXT . ' до ' . MAX_LENGTH_TASK_TEXT . ' символов';
const MESSAGE_ERROR_UNLOGGED = 'Вы разлогинены!';
const MESSAGE_ERROR_WRONG_NAME_OR_PASS = 'Вы ввели неверное имя или пароль';

const MESSAGE_SUCCESS_TASK_ADD = 'Задача успешно добавлена';
const MESSAGE_SUCCESS_LOGIN = 'Вы успешно авторизовались!';
const MESSAGE_SUCCESS_TASK_EDIT = 'Изменения сохранены';