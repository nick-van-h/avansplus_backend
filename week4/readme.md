# SQL tables used

## Users

-- Table structure

```
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','user','guest','') NOT NULL
)
```

-- Indexes

```
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
```

-- Auto increment

```
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
```

## Messages

-- Table structure

```
CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `message` blob NOT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `updateby` varchar(255) DEFAULT NULL
)
```

-- Indexes

```
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`username`);
```

-- Auto increments

```
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;
```
