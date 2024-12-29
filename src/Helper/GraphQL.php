<?php 
namespace OSW3\Utils\Helper;

class GraphQL
{
    public function simplify(array $data, string $key = null): array
    {
        $reduced = $this->reduce($data);

        if (!isset($reduced['data'][$key])) {
            return [];
        }

        return $reduced['data'][$key];
    }

    private function reduce(array $data, string $key = null)
    {
        if ($key !== null && isset($data[$key])) {
            return $this->reduce($data[$key]);
        }

        if (isset($data['edges'])) {
            return array_map(fn($edge) => $this->reduce($edge['node']), $data['edges']);
        }

        if (isset($data['node'])) {
            return $this->reduce($data['node']);
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = is_array($value) ? $this->reduce($value) : $value;
            }
        }

        return $data;
    }
}
