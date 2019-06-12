INSERT INTO socialgraph.graph (id, name)
VALUES (1, 'testcommand');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (1, 1, 'A', '{"nodes": 10}');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (2, 1, 'B', '{"nodes": 10}');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (3, 1, 'C', '{"nodes": 10}');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (4, 1, 'D', '{"meta": "graph#nodes"}');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (5, 1, 'E', '{"attributes": "graph#nodes"}');

INSERT INTO socialgraph.node (id, graph_id, name, attributes)
VALUES (6, 1, 'G', '{"attributes": "graph#nodes"}');

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, 1, 1, 2);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, 1, 1, 3);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, 1, 2, 3);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, 1, 3, 1);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, 1, 3, 4);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, 1, 5, 6);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, 1, 4, 6);

INSERT INTO socialgraph.edge (directed, weight, graph_id, source_id, destination_id)
VALUES (0, 9, 1, 4, 4);