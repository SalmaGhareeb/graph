INSERT INTO socialgraph.graph (id, name)
VALUES (1, 'testcommand');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (1, 9, 'A', '{"nodes": 10}');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (2, 9, 'B', '{"nodes": 10}');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (3, 9, 'C', '{"nodes": 10}');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (4, 9, 'D', '{"meta": "graph#nodes"}');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (5, 9, 'E', '{"attributes": "graph#nodes"}');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (6, 9, 'G', '{"attributes": "graph#nodes"}');

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, null, 1, 2);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, null, 1, 3);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, null, 2, 3);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, null, 3, 4);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, null, 4, 5);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, null, 5, 6);